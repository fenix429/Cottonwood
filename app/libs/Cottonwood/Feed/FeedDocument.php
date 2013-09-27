<?php

namespace Cottonwood\Feed;

abstract class FeedDocument
{
    abstract public function getTitle();
    abstract public function getPublishDate();
    abstract public function getTimestamp();
    abstract public function getArticles();
    
    private $_meta = [];
    
    public function getMeta($name)
    {
        $result = [];
        
        foreach ($this->_meta as $item) {
            if ($item->name === $name) {
                array_push($result, $item);
            }
        }
        
        if (count($result) == 1) {
            return array_shift($result);
        }
        
        if (empty($result)) {
            return NULL;
        }
        
        return $result;
    }
}