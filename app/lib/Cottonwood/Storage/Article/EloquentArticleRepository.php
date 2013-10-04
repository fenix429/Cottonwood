<?php 

namespace Cottonwood\Storage\Article;

use Models\Article;
use Models\Feed;

class EloquentArticleRepository implements ArticleRepository
{
    /**
	 * Find record by id
	 *
	 * @param int
	 * @return Models\Article 
	 */
    public function find($id)
    {
        return Article::findOrFail($id);
    }
    
    /**
	 * Find all records
	 * 
	 * @return Models\Article Collection
	 */
    public function findAll()
    {
        return Article::all()->orderBy('timestamp', 'desc')->get();
    }
    
    /**
	 * Find records by related feed
	 *
	 * @param int
	 * @return Models\Article Collection
	 */
    public function findByFeed($feedId)
    {
        return Article::where('feed_id', $feedId)->where('unread', TRUE)->orderBy('timestamp', 'desc')->get();
    }
    
    /**
	 * Create record
	 *
	 * @param int
	 * @param array
	 * @return Models\Article 
	 */
    public function create($feedId, $input)
    {
        $feed = Feed::findOrFail($feedId);
        $article = new Article($input);
        
        $feed->articles()->save($article);
        
        return $article;
    }
    
    /**
	 * Update record
	 *
	 * @param int
	 * @param array
	 * @return Models\Article 
	 */
    public function update($id, $input)
    {
        $article = Article::findOrFail($id);
        $article->fill($input);
        $article->save();
        
        return $article;
    }
    
    /**
	 * Delete record
	 *
	 * @param int
	 * @return void
	 */
    public function destroy($id)
    {
        Article::destroy($id);
    }
    
    /**
	 * Check for a record based on the stored hash
	 *
	 * @param string
	 * @return boolean
	 */
    public function checkArticleExists($hash)
    {
        return (bool) Article::where("hash", $hash)->count();
    }
    
    /**
	 * Remove old records
	 *
	 * @param int
	 * @param boolean
	 * @return int
	 */
    public function prune($age, $unread)
    {
        $articles = Article::where("timestamp", "<", $age);
        
        // if $unread = TRUE then unread articles will also be deleted
        if (!$unread) {
            $articles->where('unread', FALSE);
        }
        
        // return rows affected
        return $articles->delete();
    }
}