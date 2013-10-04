<?php 

namespace Cottonwood\Feed;

use \DomDocument;
use \Exception;

class Utils
{
    // Do not allow me to instantiated
    private function __construct()
    {
        
    }
    
    // Return FeedDocument Object
    public static function createFromFile($loc)
    {
        $src = @file_get_contents($loc);
        
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