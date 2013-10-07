<?php

namespace Cottonwood\Storage\Feed;

use Cottonwood\Storage\EloquentBaseModel;

class EloquentFeedModel extends EloquentBaseModel
{
    protected $table = "feeds";
    
	protected $guarded = array("id");

	public static $rules = array(
	    "title" => "required",
	    "url"   => "required|url"
	);
	
	public static $factory = array(
	    "title" => "text",
	    "url"   => "http://example.com/",
	);
	
    public function articles()
    {
        return $this->hasMany("Cottonwood\Storage\Article\EloquentArticleModel", "feed_id");
    }
}
