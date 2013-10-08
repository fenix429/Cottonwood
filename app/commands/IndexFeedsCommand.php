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
	    $repository = App::make('FeedRepository');
	    
	    foreach ($repository->findAll() as $feed) {
    		$this->info("Pushing Job to Queue: \"Indexing {$feed->url}\"");
    		Queue::push("Cottonwood\Support\Workers\FeedIndexWorker", array('feed' => $feed->toArray()));
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