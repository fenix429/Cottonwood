<?php 

namespace Cottonwood\Storage\Feed;

use EloquentFeedModel as FeedModel;

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
        return FeedModel::findOrFail($id);
    }
    
    /**
	 * Find all records
	 * 
	 * @return Models\Feed Collection
	 */
    public function findAll()
    {
        return FeedModel::all();
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
        return FeedModel::create($input);
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
        $feed = FeedModel::find($id);
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
        FeedModel::destroy($id);
    }
}