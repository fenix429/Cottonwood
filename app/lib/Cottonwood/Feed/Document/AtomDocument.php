<?php 

namespace Cottonwood\Feed\Document;

use \DateTime;
use \DomDocument;
use Cottonwood\Feed\Support\Article;
use Cottonwood\Feed\Support\Element;
use Cottonwood\Support\Exceptions\DomParseException;

class AtomDocument implements FeedDocument
{
    const FEED_TYPE = "ATOM";
    
    private $_document;
    private $_root;
    private $_articles = [];
    private $_meta = [];
    
    public function __construct(DomDocument $document)
    {
        $this->_document = $document;
        $this->_root = $document->getElementsByTagName('feed')->item(0);
        
        // process feed meta data
        foreach ($this->_root->childNodes as $child) {
            if ($child->nodeName == "entry" OR ($child->nodeName == "#text" && trim($child->nodeValue) == "")) {
                continue; // skip the entries and blank whitespace
            }
            
            array_push($this->_meta, Element::createFromDomNode($child));
        }
        
        $child = NULL;
        
        // process the entries
        $entries = $this->_root->getElementsByTagName("entry");
        
        foreach ($entries as $entry) {
            $title = "";
            $link = "";
            $summary = "";
            $content = "";
            $published = NULL;
            $item_meta = [];
            
            foreach ($entry->childNodes as $child)
            {
                try {
                    
                    $element = Element::createFromDomNode($child);
                    
                    switch ($element->name) {
                        case "title":
                            $title = $element->value;
                            break;
                        case "link":
                            $link = $element->getAttr('href');
                            break;
                        case "summary":
                            $summary = $element->value;
                            break;
                        case "content":
                            $content = $element->value;
                            break;
                        case "published": // entry should have a published element
                        case "updated": // entry might have an updated element
                            $published = DateTime::createFromFormat(DateTime::ATOM, $element->value);
                            break;
                        default:
                            array_push($item_meta, $element);
                    }
                    
                } catch (DomParseException $ex) {
                    // not an element node
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
        // the feed *should* use updated for the timestamp
        $date = $this->getMeta("updated")->value;
        
        // if not then see if there was a published element
        $date = is_null($date)? $this->getMeta("published")->value : $date;
        
        $dateTime = DateTime::createFromFormat(DateTime::ATOM, $date);
        
        return $dateTime->format($format);
    }
    
    public function getTimestamp()
    {
        // the feed *should* use updated for the timestamp
        $date = $this->getMeta("updated")->value;
        
        // if not then see if there was a published element
        $date = is_null($date)? $this->getMeta("published")->value : $date;
        
        $dateTime = DateTime::createFromFormat(DateTime::ATOM, $date);
        
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