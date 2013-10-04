<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class PruneFeedsCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'feeds:prune';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Removes old articles.';

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
	    $repository = App::make('ArticleRepository');
	    
		$ageToPrune = strtotime($this->option('age'));
		$pruneUnread = (bool) $this->option('unread');
		
		if ($ageToPrune === FALSE || $ageToPrune > time()) {
    		$this->error("Age invalid or in the future");
    		exit();
		}
		
		$rowsAffected = $repository->prune($ageToPrune, $pruneUnread);
        
        $this->info("Done, {$rowsAffected} rows deleted.");
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
			array('age', null, InputOption::VALUE_OPTIONAL, 'Articles Older than this will be pruned. Uses strtotime().', '-1 month'),
			array('unread', null, InputOption::VALUE_OPTIONAL, 'Set to true to remove unread articles as well.', FALSE)
		);
	}

}