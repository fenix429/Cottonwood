<?php

use Cottonwood\Storage\Feed\FeedRepository;

class FeedController extends BaseController
{
    public function __construct(FeedRepository $feedRepository)
    {
        $this->repository = $feedRepository;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$feeds = $this->repository->findAll();
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
		
		$feed = $this->repository->create($input);
		
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
        $feed = $this->repository->find($id);
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
		$feed = $this->repository->update($id, $input);
		
		return Response::make($feed->toJSON(), 200)->header('Content-Type', 'application/json');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->repository->destroy($id);
		
		return Response::make(json_encode(['status' => 1]), 200)->header('Content-Type', 'application/json');
	}

}
