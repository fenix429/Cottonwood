<?php

namespace Cottonwood\Storage;
 
use Illuminate\Support\ServiceProvider;
use App;
 
class StorageServiceProvider extends ServiceProvider
{

    public function register()
    {
        // Bind for Interface resolution
        App::bind('Cottonwood\Storage\Feed\FeedRepository', 'Cottonwood\Storage\Feed\EloquentFeedRepository');
        App::bind('Cottonwood\Storage\Article\ArticleRepository', 'Cottonwood\Storage\Article\EloquentArticleRepository');
        
        // Bind App::make shortcuts
        App::bind('FeedRepository', function()
        {
            return new Feed\EloquentFeedRepository();
        });
        
        App::bind('ArticleRepository', function()
        {
            return new Article\EloquentArticleRepository();
        });
    }
 
}