<?php 

/****
 * TODO:
 *  - User association (findByUser||findByUserId??)
 *  - CreateOrAssociate (with user)
 *  - RemoveAssociation (with user, and delete if no users left)
 *  - Better error handling on create and update
 */

namespace Cottonwood\Storage\Feed;

use Cottonwood\Storage\Feed\EloquentFeedModel as FeedModel;

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
        return EloquentFeedModel::findOrFail($id);
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
        $feed = new FeedModel($input);
        
        if (!$feed->save()) {
            throw new \Exception($feed->errors()->toJson());
        }
        
        return $feed;
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
		
        if (!$feed->save()) {
            throw new \Exception($feed->errors()->toJson());
        }
        
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