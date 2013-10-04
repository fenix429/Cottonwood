<?php

namespace Cottonwood\Storage\Article;

interface ArticleRepository
{
    public function find($id);
    public function findAll();
    public function findByFeed($feedId);
    public function create($feedId, $input);
    public function update($id, $input);
    public function destroy($id);
    
    public function checkArticleExists($hash);
    public function prune($age, $unread);
}