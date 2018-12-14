<?php

namespace Phoxx\Packages\Honeyroll\Controllers;

use Phoxx\Core\Renderer\View;
use Phoxx\Core\Http\Response;
use Phoxx\Core\Controllers\FrontController;

class PageNotFoundController extends FrontController
{
	public function index(): Response
	{
		return $this->display(new View('@honeyroll/pagenotfoundcontroller/index', array(
			'title' => '404'
		)), Response::HTTP_NOT_FOUND);
	}
}