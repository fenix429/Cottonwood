<?php 

namespace Cottonwood;

use \DomDocument;
use Cottonwood\Feed\AtomDocument;
use Cottonwood\Feed\RssDocument;

class Feed
{
    // Do not allow me to instantiated
    private function __construct()
    {
        
    }
    
    // Return FeedDocument Object
    public static function fetch($url)
    {
        $src = file_get_contents($url);
        
        if ($src === FALSE) {
            throw new Exception("Could not open resource.");
        }
        
        $dom = new DomDocument();
        $dom->loadXML($src);
        
        if ($dom->getElementsByTagName('feed')->item(0) !== NULL) {
            return new AtomDocument($dom);
        } else {
            return new RssDocument($dom);
        }
        
    }
    
}