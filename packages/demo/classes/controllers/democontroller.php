<?php

namespace Phoxx\Packages\Demo\Controllers;

use Phoxx\Core\Renderer\View;
use Phoxx\Core\Http\Response;
use Phoxx\Core\Controllers\FrontController;

class DemoController extends FrontController
{
	public function index(): Response
	{
		return $this->display(new View('@demo/corecontroller/index', array(
			'title' => 'Home'
		)));
	}

	public function pageNotFound(): Response
	{
		return $this->display(new View('@demo/corecontroller/pagenotfound', array(
			'title' => '404'
		)), Response::HTTP_NOT_FOUND);
	}
}