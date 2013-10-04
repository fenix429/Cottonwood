<?php

namespace Cottonwood\Storage\Feed;

interface FeedRepository
{
    public function find($id);
    public function findAll();
    public function findByUserId($userId);
    public function create($input);
    public function update($id, $input);
    public function destroy($id);
}