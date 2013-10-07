<?php 

namespace Cottonwood\Message;

class RedisMessagePublisher implements MessagePublisher
{
    private $_redis = NULL;
    private $_settings = [];
    
    public function __construct(array $options = array(), $redis = NULL)
    {
        $defaults = ["host" => "127.0.0.1", "port" => 6379, "channel" => "messages"];
        
        $this->_settings = array_merge($defaults, $options);
        
        // set injected $redis object (for testing) or new phpRedis instance
        $this->_redis = !is_null($redis)? $redis : new \Redis();
        
        // attempt to connect
        if (!$this->_redis->connect($this->_settings["host"], $this->_settings["port"])) {
            throw new \Exception("Could not establish a connection to Redis");
        }
    }
    
    public function send($room, $evt, $data)
    {
        $message = $this->_buildMessage($room, $evt, $data);
        
        $this->_redis->publish($this->_settings["channel"], $message);
    }
    
    private function _buildMessage($room, $evt, $data)
    {
        return json_encode(["room" => $room, "event" => $evt, "data" => $data]);
    }
}
