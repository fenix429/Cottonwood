<?php 

namespace Cottonwood\Storage\Feed;

use Models\Feed;
//use Models\User;

class EloquentFeedRepository implements FeedRepository
{
    public function find($id)
    {
        return Feed::findOrFail($id);
    }
    
    public function findAll()
    {
        return Feed::all();
    }
    
    public function findByUserId($userId)
    {
        // -> oauth - ?
    }
    
    public function create($input)
    {
        return Feed::create($input);
    }
    
    public function update($id, $input)
    {
        $feed = Feed::find($id);
		
		$feed->fill($input);
		
		$feed->save();
		
		return $feed;
    }
    
    public function destroy($id)
    {
        Feed::destroy($id);
    }
}