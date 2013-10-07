<?php

namespace Cottonwood\Support\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Cottonwood\Message\MessagePublisher;
use Cottonwood\Message\RedisMessagePublisher;
use App;
use Config;
 
class MessageServiceProvider extends ServiceProvider
{

    public function register()
    {
        // Interface Typehinting
        App::bind('Cottonwood\Message\MessagePublisher', 'Cottonwood\Message\RedisMessagePublisher');
        
        // App::make shortcut
        App::bind('MessagePublisher', function()
        {
            return new RedisMessagePublisher(Config::get('messages.redis'));
        });
    }
 
}