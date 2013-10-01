<?php

namespace Models;

use \Eloquent;

class Feed extends Eloquent {
	protected $guarded = array('id');

	public static $rules = array();
	
    public function articles()
    {
        return $this->hasMany('Models\Article');
    }
}
