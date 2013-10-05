<?php

class FeedEloquentModelTest extends TestCase {

	public function testDataValidation()
	{
        $feed = FactoryMuff::create("Models\Feed");
        
        $this->assertTrue($feed->validate(), "The validate() method should return true with valid data.");
        
        $feed->title = NULL;
        $feed->url = "not_a_url";
        
        $this->assertFalse($feed->validate(), "The validate() method should return false with invalid data.");
        
        $this->assertFalse($feed->errors()->isEmpty(), "On failure errors() should have messages.");
        
        $this->assertEquals(2, count($feed->errors()->all()), "There should be 2 errors.");
	}

}