<?php

use Cottonwood\Storage\Article\ArticleRepository;

class ArticleController extends BaseController
{
	public function __construct(ArticleRepository $repository)
	{
		$this->repository = $repository;
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($feedId)
	{
		$articles = $this->repository->findByFeed($feedId);
		
		return Response::make($articles->toJSON(), 200)->header('Content-Type', 'application/json');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($feedId, $articleId)
	{
		$article = $this->repository->find($articleId);
		
		return Response::make($article->toJSON(), 200)->header('Content-Type', 'application/json');
	}

}
