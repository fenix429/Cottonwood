<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Cottonwood\Storage\Feed\FeedRepository;
use Cottonwood\Storage\Article\ArticleRepository;

class IndexFeedsCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'feeds:index';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Crawls the feeds stored in the system.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
	    $this->repos = new stdClass();
	    $this->repos->feeds = App::make('FeedRepository');
	    $this->repos->articles = App::make('ArticleRepository');
	    
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
	    foreach ($this->repos->feeds->findAll() as $feed) {
    		$this->info("Fetching {$feed->url}");
    		
    		try {
        		
        		$feedDoc = FeedBuilder::createFromFile($feed->url);
        		$room = "feed-{$feed->id}";
        		$buffer = [];
                $cnt = 0;
                
        		foreach ($feedDoc->getArticles() as $article) {
        		    
        		    // if record exists
            		if ($this->repos->articles->checkArticleExists($article->getHash())) {
                		continue; // skip this article
            		}
            		
            		// store the article in the database
            		$this->repos->articles->create($feed->id, $article->toArray());
            		
            		// and buffer it for later
            		array_push($buffer, $article->toArray());
            		
            		$cnt++;
        		}
        		
        		$this->info("Indexed {$cnt} article(s)");
        		
        		// sort the articles on their timestamp
        		usort($buffer, function($a, $b)
        		{
            		if ($a["timestamp"] === $b["timestamp"]) {
                		return 0; // same
            		}
            		
            		return ($a["timestamp"] < $b["timestamp"]) ? -1 : 1;
        		});
        		
        		// then walk through the buffer and push the articles
        		array_walk($buffer, function($article) use ($room)
        		{
    	    		MessagePublisher::send($room, "newArticle", $article);
        		});
        		
    		} catch (Exception $ex) {
        		$this->error("Error fetching {$feed->url}\n\n" . $ex->getMessage());
    		}
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			//array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			//array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}