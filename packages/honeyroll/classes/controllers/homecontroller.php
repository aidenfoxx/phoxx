<?php

namespace Phoxx\Packages\Honeyroll\Controllers;

use Phoxx\Core\Renderer\View;
use Phoxx\Core\Http\Response;
use Phoxx\Core\Controllers\FrontController;

class HomeController extends FrontController
{
	public function index(): Response
	{
		return $this->display(new View('@honeyroll/homecontroller/index', array(
			'title' => 'Home'
		)));
	}
}