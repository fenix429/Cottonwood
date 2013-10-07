<?php

namespace Cottonwood\Support\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use Cottonwood\Feed\FeedBuilder;
use App;
 
class FeedBuilderServiceProvider extends ServiceProvider
{

    public function register()
    {
        App::singleton('FeedBuilder', function()
        {
            return new FeedBuilder();
        });
    }
 
}