<?php

class FeedsTableSeeder extends Seeder {

	public function run()
	{
	    DB::statement("SET FOREIGN_KEY_CHECKS=0;");
	    
		DB::table("feeds")->truncate();
        
        DB::statement("SET FOREIGN_KEY_CHECKS=1;");
        
		$feeds = array(
			["title" => "ArsTechnica", "url" => "http://feeds.arstechnica.com/arstechnica/index"],
			["title" => "ReadWrite",   "url" => "http://www.readwriteweb.com/rss.xml"],
			["title" => "TechCrunch",  "url" => "http://feeds.feedburner.com/TechCrunch/"],
			["title" => "io9",         "url" => "http://feeds.gawker.com/io9/full"],
			["title" => "Slashdot",    "url" => "http://rss.slashdot.org/Slashdot/slashdot"]
		);
		
		array_walk($feeds, function(&$feed)
		{
    		$feed = array_merge($feed, [ "created_at" => new DateTime(), "updated_at" => new DateTime() ]);
		});

		DB::table("feeds")->insert($feeds);
	}

}
