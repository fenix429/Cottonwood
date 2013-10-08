<?php

use Cottonwood\Feed\Support\Article;
use Cottonwood\Feed\Support\Element;

class FeedLibrarySupportClassesTest extends TestCase
{
    public function testArticleClass()
    {
        $title = "The Title";
        $link = "http://example.com";
        $summary = "The Summary";
        $content = "<p>The Content</p>";
        $published = new DateTime();
        
        $one = new stdClass();
        $one->name = "one";
        $one->value = 1;
        
        $two = new stdClass();
        $two->name = "two";
        $two->value = 2;
        
        $three = new stdClass();
        $three->name = "two"; // didn't see that comming did ya?
        $three->value = 3;
        
        $meta = [$one, $two, $three];
        
        $article = new Article($title, $link, $summary, $content, $published, $meta);
        
        $this->assertEquals($title, $article->getTitle(), 'The title should be set properly.');
        
        $this->assertEquals($link, $article->getLink(), 'The link should be set properly.');
        
        $this->assertEquals($summary, $article->getSummaryAsText(), 'The summary should be set properly.');
        $this->assertEquals('<p>' . $summary . '</p>', $article->getSummary(), 'The summary should have been run through HTMLPurifier.');
        
        $this->assertEquals($content, $article->getContent(), 'The content should be set properly.');
        $this->assertTrue($article->hasContent(), 'The has content method should return true if there is content set');
        
        $this->assertSame($published->getTimestamp(), $article->getTimestamp(), 'The getTimestamp() method should return a timestamp of the publish date.');
        $this->assertSame($published->format("D, d M Y h:i a"), $article->getPublishDate(), 'The getPublishDate() method should return a formatted string of the publish date.');
        
        $hash = md5($title . $link . $published->getTimestamp());
        
        $this->assertEquals($hash, $article->getHash(), 'The getHash() method should calculate and return the hash of the article.');
        $this->assertTrue($article->compareHash($hash), 'The compareHash() method should return true when the article\'s hash is supplied.');
        
        $this->assertEquals($one, $article->getMeta('one'), 'The getMeta() method should return the value of key supplied if there is one value in the meta list.');
        $this->assertEquals([$two, $three], $article->getMeta('two'), 'The getMeta() method should return an array of values of the key supplied if there is more than one value in the meta list.');
        
        $array = [
            "title"     => $title,
    	    "link"      => $link,
            "summary"   => '<p>' . $summary . '</p>',
    	    "content"   => $content,
            "timestamp" => $published->getTimestamp(),
            "hash"      => $hash
        ];
        
        $this->assertSame($array, $article->toArray(), 'The toArray() method should return an array with the proper values.');
        $this->assertSame(json_encode($array), $article->toJSON(), 'The toJSON() method should return a json encoded string of the values.');
    }
    
    public function testElementClass()
    {
        $element = new Element('name', 'value', ['attr' => 'attrVal']);
        
        $element->name = 'newName';
        $this->assertTrue($element->name === 'newName', 'We should be able to set the name attribute.');
        
        $element->value = 'newValue';
        $this->assertTrue($element->value === 'newValue', 'We should be able to set the value attribute.');
        
        $element->attrs = ['different' => 'attribute'];
        $this->assertFalse($element->attrs === ['different' => 'attribute'], 'We should not be able to set the attrs attribute.');
        
        $this->assertEquals('attrVal', $element->getAttr('attr'), 'The getAttr() method should return the correct value from attrs.');
        
        $element->setAttr('attr', 'newAttrVal');
        $this->assertEquals('newAttrVal', $element->getAttr('attr'), 'The setAttr() method should change an existing value in attrs.');
        
        $element->setAttr('otherAttr', 'otherAttrVal');
        $this->assertEquals('otherAttrVal', $element->getAttr('otherAttr'), 'The setAttr() method should set a new value in attrs.');
    }
    
    public function testElementFactory()
    {
        $firstFragment = '<div id="myDiv"><p>Mary had a little lamb</p><p>It\'s fleece was white as snow</p></div>';
        $secondFragment = '<div id="myOtherDiv">And everywhere that Mary went, the lamb was sure to go.</div>';
        
        $doc = new DOMDocument();
        
        $doc->loadXML($firstFragment);
        $firstNode = $doc->getElementsByTagName('div')->item(0);
        
        $doc->loadXML($secondFragment);
        $secondNode = $doc->getElementsByTagName('div')->item(0);
        
        $firstElement = Element::createFromDomNode($firstNode);
        $secondElement = Element::createFromDomNode($secondNode);
        
        $this->assertEquals('div', $firstElement->name, 'The name should be set correctly.');
        
        $this->assertEquals('<p>Mary had a little lamb</p><p>It\'s fleece was white as snow</p>', $firstElement->value, 'The value should be set correctly when the node contains children.');
        
        $this->assertEquals('And everywhere that Mary went, the lamb was sure to go.', $secondElement->value, 'The value should be set correctly when the node does not contain children.');
        
        $this->assertEquals('myDiv', $firstElement->getAttr('id'), 'The node attributes should be parsed correctly.');
    }
    
    /**
     * @expectedException Cottonwood\Support\Exceptions\DomParseException
     * @expectedExceptionMessage Cannot create Element from from Non-Element Node.
     */
    public function testElementFactoryException()
    {
        $fragment = "<div>Mary had a little lamb, It's fleece was white as snow.</div>";
        
        $doc = new DomDocument();
        
        $doc->loadXML($fragment);
        $textNode = $doc->getElementsByTagName("div")->item(0)->firstChild;
        
        Element::createFromDomNode($textNode);
    }
}






