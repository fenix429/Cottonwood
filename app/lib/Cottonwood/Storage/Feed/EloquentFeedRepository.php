<?php 

namespace Cottonwood\Storage\Feed;

use Models\Feed;

class EloquentFeedRepository implements FeedRepository
{
    /**
	 * Find record by id
	 *
	 * @param int
	 * @return Models\Feed 
	 */
    public function find($id)
    {
        return Feed::findOrFail($id);
    }
    
    /**
	 * Find all records
	 * 
	 * @return Models\Feed Collection
	 */
    public function findAll()
    {
        return Feed::all();
    }
    
    /**
	 * Find records by related user
	 *
	 * @param int
	 * @return Models\Feed Collection
	 */
    public function findByUserId($userId)
    {
        // -> oauth - ?
    }
    
    /**
	 * Create record
	 * 
	 * @param array
	 * @return Models\Feed 
	 */
    public function create($input)
    {
        return Feed::create($input);
    }
    
    /**
	 * Update record
	 *
	 * @param int
	 * @param array
	 * @return Models\Feed 
	 */
    public function update($id, $input)
    {
        $feed = Feed::find($id);
		$feed->fill($input);
		$feed->save();
		
		return $feed;
    }
    
    /**
	 * Delete record
	 *
	 * @param int
	 * @return void
	 */
    public function destroy($id)
    {
        Feed::destroy($id);
    }
}