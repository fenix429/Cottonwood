<?php 

/*
 * Learn more about RSS 1.0!
 * 
 * this might (is likely to?) to choke HARD on anything < RSS 2.0
 * 
 */

namespace Cottonwood\Feed;

use DateTime;
use DomDocument;
use Cottonwood\Feed\Article;
use Cottonwood\Feed\Element;

class RssDocument extends FeedDocument
{
    const FEED_TYPE = "RSS";
    
    private $_document;
    private $_root;
    private $_articles = [];
    private $_meta = [];
    
    public function __construct(DomDocument $document)
    {
        $this->_document = $document;
        $this->_root = $document->getElementsByTagName('channel')->item(0);
        
        // process feed meta data
        foreach ($this->_root->childNodes as $child) {
            if ($child->nodeName == "item" OR ($child->nodeName == "#text" && trim($child->nodeValue) == "")) {
                continue; // skip the items and blank whitespace
            }
            
            array_push($this->_meta, Element::createFromDomNode($child));
        }
        
        $child = NULL;
        
        // process the items
        $items = $this->_root->getElementsByTagName('item');
        
        foreach ($items as $item) {
            $title = "";
            $link = "";
            $summary = "";
            $content = "";
            $published = NULL;
            $item_meta = [];
            
            foreach ($item->childNodes as $child)
            {
                if ($child->nodeName == "#text" && trim($child->nodeValue) == "") {
                    continue; // skip blank whitespace
                }
                
                $element = Element::createFromDomNode($child);
                
                switch ($element->name) {
                    case "title":
                        $title = $element->value;
                        break;
                    case "link":
                        $link = $element->value;
                        break;
                    case "description":
                        $summary = $element->value;
                        break;
                    case "content:encoded":
                        $content = $element->value;
                        break;
                    case "pubDate":
                        $published = DateTime::createFromFormat(DateTime::RSS, $element->value);
                        break;
                    default:
                        array_push($item_meta, $element);
                }
            }
            
            array_push($this->_articles, new Article($title, $link, $summary, $content, $published, $item_meta));
        }
    }
    
    public function getTitle()
    {
        return $this->getMeta("title")->value;
    }
    
    public function getPublishDate($format = "D, d M Y h:i a")
    {
        $dateTime = DateTime::createFromFormat(DateTime::RSS, $this->getMeta("pubDate")->value);
        
        return $dateTime->format($format);
    }
    
    public function getTimestamp()
    {
        $dateTime = DateTime::createFromFormat(DateTime::RSS, $this->getMeta("pubDate")->value);
        
        return $dateTime->getTimestamp();
    }
    
    public function getArticles()
    {
        return $this->_articles;
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
}