<?php

namespace Cottonwood\Feed;
 
use Illuminate\Support\ServiceProvider;
use App;
 
class FeedServiceProvider extends ServiceProvider
{

    public function register()
    {
        App::singleton('FeedBuilder', function()
        {
            return new FeedBuilder();
        });
    }
 
}