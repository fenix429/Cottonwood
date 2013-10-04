<?php

namespace Models;

use \Eloquent;

class Article extends Eloquent {
	protected $guarded = array("id", "created_at", "updated_at");

	public static $rules = array();
	
	public function feed()
    {
        return $this->belongsTo('Models\Feed');
    }
    
    public function scopeUnread($query)
    {
        return $query->where('unread', TRUE);
    }
}
