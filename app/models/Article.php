<?php

namespace Models;

class Article extends BaseModel
{
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
		"feed_id"   => "factory|Models\Feed",
		"timestamp" => 1380943435
	);
	
	public function feed()
    {
        return $this->belongsTo("Models\Feed");
    }
    
    public function scopeUnread($query)
    {
        return $query->where("unread", TRUE);
    }
}
