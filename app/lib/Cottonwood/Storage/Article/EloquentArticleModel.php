<?php

namespace Cottonwood\Storage\Article;

use Cottonwood\Storage\EloquentBaseModel;

class EloquentArticleModel extends EloquentBaseModel
{
    protected $table = "articles";
    
	protected $guarded = array("id", "created_at", "updated_at");

	public static $rules = array(
	    "title"     => "required",
		"link"      => "required|url",
		"summary"   => "required",
		"content"   => "required",
		"hash"      => "required|unique:articles,hash",
		"timestamp" => "required|integer"
	);
	
	public static $factory = array(
	    "title"     => "text",
		"link"      => "http://example.com/article1.htm",
		"summary"   => "text",
		"content"   => "text",
		"hash"      => "string",
		"feed_id"   => "factory|Cottonwood\Storage\Feed\EloquentFeedModel",
		"timestamp" => 1380943435
	);
	
	public function feed()
    {
        return $this->belongsTo("Cottonwood\Storage\Feed\EloquentFeedModel");
    }
    
    public function scopeUnread($query)
    {
        return $query->where("unread", TRUE);
    }
}
