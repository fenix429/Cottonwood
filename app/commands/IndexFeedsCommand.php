<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

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
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		$feeds = Models\Feed::all();
		$redis = new Redis();
		$redis->connect('127.0.0.1', 6379);
		
		foreach ($feeds as $feed) {
    		$this->info("Fetching {$feed->url}");
    		
    		try {
        		
        		$feedDoc = Cottonwood\Feed\Utils::createFromFile($feed->url);
                $cnt = 0;
                
        		foreach ($feedDoc->getArticles() as $articleObj) {
            		$recordExists = DB::table("articles")->where("hash", $articleObj->getHash())->count();
            		
            		if ($recordExists) {
                		continue; // skip this article
            		}
            		
            		$articleModel = Models\Article::createFromObject($articleObj);
            		
            		$feed->articles()->save($articleModel);
            		$redis->publish("cw-notif", json_encode( ["room" => "feed-{$feed->id}", "article" => $articleModel->toArray()] ));
            		
            		$cnt++;
        		}
        		
        		$this->info("Indexed {$cnt} article(s)");
        		
    		} catch (Exception $ex) {
        		$this->error("Error fetching {$feed->url}");
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