<?php 

namespace Cottonwood\Feed;

use \DomDocument;
use \Exception;

class FeedBuilder
{
    public function __construct()
    {
        
    }
    
    // Return FeedDocument Object
    public function createFromFile($loc)
    {
        $src = @file_get_contents($loc);
        
        if ($src === FALSE) {
            throw new Exception("Could not open resource.");
        }
        
        $dom = new DomDocument();
        $dom->loadXML($src);
        
        if ($dom->getElementsByTagName('feed')->item(0) !== NULL) {
            return new Document\AtomDocument($dom);
        } else {
            return new Document\RssDocument($dom);
        }
        
    }
    
}