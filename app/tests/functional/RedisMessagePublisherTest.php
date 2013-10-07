<?php

use Cottonwood\Message\RedisMessagePublisher as MessagePublisher;

class RedisMessagePublisherTest extends TestCase
{    
    public function tearDown()
    {
        Mockery::close();
    }
    
	public function testConstructor()
	{
	    $config = ["host" => "127.0.0.1", "port" => 6379, "channel" => "messages-test"];
	    
        $mock = Mockery::mock("Redis");
        $mock->shouldReceive("connect")->with("127.0.0.1", 6379)->andReturn(TRUE);
        
        $publisher = new MessagePublisher($config, $mock);
	}
	
	/**
     * @expectedException Exception
     * @expectedExceptionMessage Could not establish a connection to Redis
     */
	public function testConstructorException()
	{
    	$config = ["host" => "127.0.0.1", "port" => 6379, "channel" => "messages-test"];
	    
        $mock = Mockery::mock("Redis", ["connect" => FALSE]);
        
        $publisher = new MessagePublisher($config, $mock);
	}
	
	public function testSend()
	{
    	$room = "test-room";
    	$data = ["one" => 1, "two" => 2, "three" => 3, "four" => 4];
    	$message = json_encode(["room" => $room, "data" => $data]);
    	$config = ["host" => "127.0.0.1", "port" => 6379, "channel" => "messages-test"];
	    
        $mock = Mockery::mock("Redis", ["connect" => TRUE]);
        $mock->shouldReceive("publish")->with("messages-test", $message);
        
        $publisher = new MessagePublisher($config, $mock);
        
        $publisher->send($room, $data);
	}

}