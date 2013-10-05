<?php

class ArticleEloquentModelTest extends TestCase
{
	public function testDataValidation()
	{
        $article = FactoryMuff::create("Models\Article");
        
        $this->assertTrue($article->validate(), "The validate() method should return true with valid data.");
        
        $article->title = NULL;
        $article->link = "not_a_url";
        $article->timestamp = "hello";
        
        $this->assertFalse($article->validate(), "The validate() method should return false with invalid data.");
        
        $this->assertFalse($article->errors()->isEmpty(), "On failure errors() should have messages.");
        
        $this->assertEquals(3, count($article->errors()->all()), "There should be 3 errors.");
	}
    
	public function testRelationships()
	{
    	$article = FactoryMuff::create("Models\Article");
    	
    	$this->assertInstanceOf("Models\Feed", $article->feed()->first(), "The Article should belong to a Feed.");
	}
}