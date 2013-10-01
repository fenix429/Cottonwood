<?php

namespace Models;

use \Eloquent;
use \Cottonwood\Feed\Article as ArticleObj;

class Article extends Eloquent {
	protected $guarded = array("id", "created_at", "updated_at");

	public static $rules = array();
	
	public function feed()
    {
        return $this->belongsTo('Models\Feed');
    }
	
	public static function createFromObject(ArticleObj $articleObj)
	{
    	return new Article($articleObj->toArray());
	}
}
