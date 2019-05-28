<?php

namespace Phoxx\Packages\Demo\Controllers;

use Phoxx\Core\Renderer\View;
use Phoxx\Core\Http\Response;
use Phoxx\Core\Controllers\Controller;

class DemoController extends Controller
{
	use \Phoxx\Core\Controllers\Traits\DisplayController;

	public function index(): Response
	{
		return $this->display(new View('@demo/DemoController/index', array(
			'title' => 'Home'
		)));
	}

	public function pageNotFound(): Response
	{
		return $this->display(new View('@demo/DemoController/pageNotFound', array(
			'title' => '404'
		)), Response::HTTP_NOT_FOUND);
	}

	public function internalServerError(): Response
	{
		return $this->display(new View('@demo/DemoController/internalServerError', array(
			'title' => '500'
		)), Response::HTTP_INTERNAL_SERVER_ERROR);
	}
}