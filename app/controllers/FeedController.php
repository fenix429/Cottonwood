<?php

class FeedController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$feeds = Models\Feed::all();
        return Response::make($feeds->toJSON(), 200)->header('Content-Type', 'application/json');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		
		$feed = Models\Feed::create($input);
		$feed->save();
		
		return Response::make($feed->toJSON(), 200)->header('Content-Type', 'application/json');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $feed = Models\Feed::find($id);
        return Response::make($feed->toJSON(), 200)->header('Content-Type', 'application/json');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = Input::all();
		$feed = Models\Feed::find($id);
		
		$feed->fill($input);
		$feed->save();
		
		return Response::make($feeds->toJSON(), 200)->header('Content-Type', 'application/json');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Models\Feed::destroy($id);
		
		return Response::make(json_encode(null), 200)->header('Content-Type', 'application/json');
	}

}
