<?php

class FeedControllerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        
        // Create a Mock of the Repository
        $this->mock = Mockery::mock('Cottonwood\Storage\Feed\FeedRepository');
        
        // Bind our mock to the IoC
        $this->app->instance('Cottonwood\Storage\Feed\FeedRepository', $this->mock);
    }
    
    public function tearDown()
    {
        Mockery::close();
    }
    
	public function testIndex()
	{
	    $jsonData = json_encode([1, 2, 3, 4, 5]);
	    
        $this->mock
            ->shouldReceive('findAll')
            ->once()
            ->andReturn( Mockery::mock([ 'toJSON' => $jsonData ]) );
        
        $this->call('GET', 'feed');
        
        $this->assertResponseOk();
        
        $this->assertEquals($jsonData, $this->client->getResponse()->getContent());
	}
	
	public function testStore()
	{
    	Input::replace($input = ['title' => 'My Title', 'url' => 'http://example.com']);
    	
    	$jsonData = json_encode($input);
    	
    	$this->mock
    	    ->shouldReceive('create')
    	    ->with(Mockery::type('array'))
    	    ->once()
    	    ->andReturn( Mockery::mock([ 'toJSON' => $jsonData ]) );
        
        $this->call('POST', 'feed');
        
        $this->assertResponseOk();
        
        $this->assertEquals($jsonData, $this->client->getResponse()->getContent());
	}
	
	public function testShow()
	{
	    $jsonData = json_encode([ 'title' => 'My Title', 'url' => 'http://example.com' ]);
	    
    	$this->mock
            ->shouldReceive('find')
            ->with(1)
            ->once()
            ->andReturn( Mockery::mock([ 'toJSON' => $jsonData ]) );
        
        $this->call('GET', 'feed/1');
        
        $this->assertResponseOk();
        
        $this->assertEquals($jsonData, $this->client->getResponse()->getContent());
	}
	
	public function testUpdate()
	{
    	Input::replace($input = ['title' => 'My Title', 'url' => 'http://example.com']);
    	
    	$jsonData = json_encode($input);
    	
    	$this->mock
    	    ->shouldReceive('update')
    	    ->with(1, Mockery::type('array'))
    	    ->once()
    	    ->andReturn( Mockery::mock([ 'toJSON' => $jsonData ]) );
        
        $this->call('PUT', 'feed/1');
        
        $this->assertResponseOk();
        
        $this->assertEquals($jsonData, $this->client->getResponse()->getContent());
	}
	
	public function testDestroy()
	{
	    $jsonData = json_encode(['status' => 1]);
	    
    	$this->mock
    	    ->shouldReceive('destroy')
    	    ->with(1)
    	    ->once()
    	    ->andReturn( Mockery::mock([ 'toJSON' => $jsonData ]) );
        
        $this->call('DELETE', 'feed/1');
        
        $this->assertResponseOk();
        
        $this->assertEquals($jsonData, $this->client->getResponse()->getContent());
	}
}