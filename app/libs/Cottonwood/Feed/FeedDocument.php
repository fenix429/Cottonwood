<?php

namespace Cottonwood\Feed;

abstract class FeedDocument
{
    abstract public function getTitle();
    abstract public function getPublishDate();
    abstract public function getTimestamp();
    abstract public function getArticles();
    abstract public function getMeta($name);
}