<?php

namespace Models;

class Feed extends BaseModel
{
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
        return $this->hasMany("Models\Article");
    }
}
