<?php

class ArticleController extends BaseController {
	
	// Dummy content
	var $articles = array();
	
	public function __construct()
	{
		
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($feedId)
	{
		$articles = Models\Feed::find($feedId)->articles()->where('unread', TRUE)->get();
		
		return Response::make($articles->toJSON(), 200)->header('Content-Type', 'application/json');
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

}
