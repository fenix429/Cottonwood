<?php

namespace Models;

use Eloquent;
use Validator;
use Illuminate\Support\MessageBag;

class BaseModel extends Eloquent
{
	public static $rules = array();
	protected $_errors = NULL;
	
	public function validate()
	{
	    $rules = static::$rules;
	    
        // exclude the current user id from 'unqiue' validators
        if ($this->id > 0) {
            array_walk($rules, function(&$rule)
            {
                // for this to work the unique rule must be last and must have the table listed
                if (preg_match("/unique,[\w+],[\w+]$/i", $rule)) {
                    $rule .= "," . $this->id;
                }
            });
        }
	    
    	$validator = Validator::make($this->toArray(), $rules);
    	
    	if ($validator->fails()) {
        	$this->_errors = $validator->messages();
        	return FALSE;
    	}
    	
    	return TRUE;
	}
	
	public function errors($clearErrors = false)
	{
    	$errors = $this->_errors;
    	
    	if (is_null($errors)) {
        	return new MessageBag([]); // return an empty message bag
    	}
    	
    	if ($clearErrors) {
        	$this->_errors = NULL;
    	}
    	
    	return $errors;
	}
	
	public function save(array $options = array())
	{
	    if ($this->validate()) {
    	    return parent::save($options);
    	}
    	
    	return FALSE;
	}
}
