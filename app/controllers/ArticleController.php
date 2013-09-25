<?php

class ArticleController extends BaseController {
	
	// Dummy content
	var $articles = array();
	
	public function __construct()
	{
		$this->articles = array(
			array(
				"title" => "Article 1",
				"url" => "http://www.example.com/some/url/here/1",
				"text" => $this->_random_lipsum(),
			),
			array(
				"title" => "Article 2",
				"url" => "http://www.example.com/some/url/here/2",
				"text" => $this->_random_lipsum(),
			),
			array(
				"title" => "Article 3",
				"url" => "http://www.example.com/some/url/here/3",
				"text" => $this->_random_lipsum(),
			),
			array(
				"title" => "Article 4",
				"url" => "http://www.example.com/some/url/here/4",
				"text" => $this->_random_lipsum(),
			),
			array(
				"title" => "Article 5",
				"url" => "http://www.example.com/some/url/here/5",
				"text" => $this->_random_lipsum(),
			),
			array(
				"title" => "Article 6",
				"url" => "http://www.example.com/some/url/here/6",
				"text" => $this->_random_lipsum(),
			)
		);
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($feedId)
	{
		$articles = $this->_add_feed_id($feedId, $this->articles);
		
		return Response::make(json_encode($articles), 200)->header('Content-Type', 'application/json');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($feedId)
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($feedId)
	{
		
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($feedId, $taskId)
	{
		
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($feedId, $taskId)
	{
		
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($feedId, $taskId)
	{
		
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($feedId, $taskId)
	{
		
	}
	
	private function _add_feed_id($feedId, $articles)
	{
		return array_map(function($article) use ($feedId){
			$article["feed_id"] = $feedId;
			return $article;
		}, $articles);
	}
	
	private function _random_lipsum($amount = 1, $what = 'paras', $start = 0)
	{
		return (string) simplexml_load_file("http://www.lipsum.com/feed/xml?amount={$amount}&what={$what}&start={$start}")->lipsum;
	}

}
