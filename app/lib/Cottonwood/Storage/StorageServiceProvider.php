<?php

namespace Cottonwood\Storage;
 
use Illuminate\Support\ServiceProvider;
 
class StorageServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind('Cottonwood\Storage\Feed\FeedRepository', 'Cottonwood\Storage\Feed\EloquentFeedRepository');
    }
 
}