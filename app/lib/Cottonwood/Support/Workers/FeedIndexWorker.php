<?php 

namespace Cottonwood\Support\Workers;

use App;
use Log;
use FeedBuilder;
use MessagePublisher;
use Cottonwood\Support\Exceptions\FileReadException;

class FeedIndexWorker
{
    public function fire($job, $data)
    {
        $feed = $data["feed"];
        
        // delete this job if it fails three times
        if ($job->attempts() > 3) {
            Log::error("Attempts to parse {$feed['url']} maxed out. Deleting Job.");
            
            $job->delete();
            
            return;
        }
        
        try {
            $repository = App::make("ArticleRepository");
            $feedDoc = FeedBuilder::createFromFile($feed["url"]);
    		$room = "feed-{$feed['id']}";
    		$buffer = [];
            $cnt = 0;
            
    		foreach ($feedDoc->getArticles() as $article) {
    		    
    		    // if record exists
        		if ($repository->checkArticleExists($article->getHash())) {
            		continue; // skip this article
        		}
        		
        		// store the article in the database
        		$repository->create($feed["id"], $article->toArray());
        		
        		// and buffer it for later
        		array_push($buffer, $article->toArray());
    		}
            
            // once the articles are saved to the database, delete the job from the queue
            $job->delete();
    		
    		// sort the buffered articles on their timestamp
    		usort($buffer, function($a, $b)
    		{
        		if ($a["timestamp"] === $b["timestamp"]) {
            		return 0; // same
        		}
        		
        		return ($a["timestamp"] < $b["timestamp"]) ? -1 : 1;
    		});
    		
    		// then walk through the buffer and push the articles to the clients
    		array_walk($buffer, function($article) use ($room)
    		{
	    		MessagePublisher::send($room, "newArticle", $article);
    		});
            
        } catch (ConnectionException $ex) {
            
            // thrown by MessagePublisher
            Log::error( $ex->getMessage() );
            
        } catch (FileReadException $ex) {
            
            // if we can"t open the feed try again in 30 minutes
            $job->release(60 * 30);
            
        }
    }
}