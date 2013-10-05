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
		// phpRedis extension - not Redis facade!
		$redis = new Redis();
		$redis->connect('127.0.0.1', 6379);
		
		foreach ($this->repos->feeds->findAll() as $feed) {
    		$this->info("Fetching {$feed->url}");
    		
    		try {
        		
        		$feedDoc = FeedBuilder::createFromFile($feed->url);
                $cnt = 0;
                
        		foreach ($feedDoc->getArticles() as $articleObj) {
        		    // if record exists
            		if ($this->repos->articles->checkArticleExists($articleObj->getHash())) {
                		continue; // skip this article
            		}
            		
            		$articleModel = $this->repos->articles->create($feed->id, $articleObj->toArray());
            		
            		$redis->publish("cw-notif", json_encode( ["room" => "feed-{$feed->id}", "article" => $articleModel->toArray()] ));
            		
            		$cnt++;
        		}
        		
        		$this->info("Indexed {$cnt} article(s)");
        		
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