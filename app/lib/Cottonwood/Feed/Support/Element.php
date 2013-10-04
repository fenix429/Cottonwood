<?php 

namespace Cottonwood\Feed\Support;

use \DomNode;

class Element
{
    private $_name;
    private $_value;
    private $_attrs;
    
    public function __construct($name, $value, $attrs = [])
    {
        $this->_name = (string) $name;
        $this->_value = (string) $value;
        $this->_attrs = is_array($attrs)? $attrs : [];
    }
    
    // Factory
    public static function createFromDomNode(DomNode $node)
    {
        if ($node->nodeType != XML_ELEMENT_NODE) {
            throw new \Exception("Cannot create Element from from Non-Element Node.");
        }
        
        $name = $node->nodeName;
        $value = $node->nodeValue;
        $attrs = [];
        
        if (Element::_nodeHasChildElements($node)) {
            $value = Element::_getNodesInnerXML($node);
        }
        
        foreach ($node->attributes as $attribute) {
            $attrs[$attribute->name] = $attribute->value;
        }
        
        return new Element($name, $value, $attrs);
    }
    
    // Getter & Setters
    public function __get($prop)
    {
        if ($prop === 'name') {
            return $this->_name;
        } elseif ($prop === 'value') {
            return $this->_value;
        } elseif ($prop === 'attrs') {
            return $this->_attrs;
        }
        
        return NULL;
    }
    
    public function __set($prop, $value)
    {
        if ($prop === 'name') {
            $this->_name = $value;
        } elseif ($prop === 'value') {
            $this->_value = $value;
        }
    }
    
    public function getAttr($key)
    {
        if (array_key_exists($key, $this->_attrs)) {
            return $this->_attrs[$key];
        }
        
        return NULL;
    }
    
    public function setAttr($key, $value)
    {
        $this->_attrs[$key] = $value;
    }
    
    // Utils
    private static function _getNodesInnerXML(DomNode $node) 
    { 
        $innerXML = "";
    
        foreach ($node->childNodes as $child) {
            $innerXML .= $node->ownerDocument->saveXML($child);
        }
        
        return $innerXML; 
    }
    
    private static function _nodeHasChildElements(DomNode $node)
    {
        if ($node->nodeType != XML_ELEMENT_NODE) {
            return FALSE; // only elements can have children
        }
        
        foreach ($node->childNodes as $child)
        {
            if ($child->nodeType == XML_ELEMENT_NODE) {
                return TRUE;
            }
        }
        
        return FALSE;
    }
}