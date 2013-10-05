<?php

namespace Cottonwood\Feed\Document;

interface FeedDocument
{
    public function getTitle();
    public function getPublishDate();
    public function getTimestamp();
    public function getArticles();
    public function getMeta($name);
}