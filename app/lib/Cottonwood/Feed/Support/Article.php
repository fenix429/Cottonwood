<?php 

namespace Cottonwood\Feed\Support;

use \DateTime;
use Mews\Purifier\Purifier;

class Article
{
    private $_title;
    private $_link;
    private $_summary;
    private $_content;
    private $_published;
    private $_meta;
    
    public function __construct($title, $link, $summary, $content, $published, $meta = [])
    {
        $this->_title     = htmlentities($title);
        $this->_link      = htmlspecialchars($link);
        $this->_summary   = Purifier::clean(trim($summary));
        $this->_content   = Purifier::clean(trim($content));
        $this->_published = ($published instanceof DateTime)? $published : NULL;
        $this->_meta      = is_array($meta)? $meta : [];
    }
    
    public function getTitle()
    {
        return $this->_title;
    }
    
    public function getLink()
    {
        return $this->_link;
    }
    
    public function getSummary()
    {
        return trim($this->_summary);
    }
    
    public function getSummaryAsText()
    {
        return htmlentities(strip_tags($this->_summary));
    }
    
    public function hasContent()
    {
        return !empty($this->_content);
    }
    
    public function getContent()
    {
        return trim($this->_content);
    }
    
    public function getPublishDate($format = "D, d M Y h:i a")
    {
        return is_null($this->_published)? NULL : $this->_published->format($format);
    }
    
    public function getTimestamp()
    {
        return is_null($this->_published)? NULL : $this->_published->getTimestamp();
    }
    
    public function getHash()
    {
        return md5($this->_title . $this->_link . $this->getTimestamp());
    }
    
    public function compareHash($hash)
    {
        return $hash === $this->getHash();
    }
    
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
    
    public function toArray()
    {
        return [
    	    "title"     => $this->getTitle(),
    	    "link"      => $this->getLink(),
    	    "summary"   => $this->getSummary(),
    	    "content"   => $this->getContent(),
    	    "timestamp" => $this->getTimestamp(),
    	    "hash"      => $this->getHash()
    	];
    }
    
    public function toJSON()
    {
        return json_encode($this->toArray());
    }
}