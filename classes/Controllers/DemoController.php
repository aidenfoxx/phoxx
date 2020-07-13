<?php

namespace Phoxx\Controllers;

use Phoxx\Core\Controllers\FrontController;
use Phoxx\Core\Http\Response;
use Phoxx\Core\Renderer\View;

class DemoController extends FrontController
{
  public function index(): Response
  {
    return $this->display(new View('./DemoController/index', array(
      'title' => 'Home'
    )));
  }

  public function pageNotFound(): Response
  {
    return $this->display(new View('./DemoController/pageNotFound', array(
      'title' => '404'
    )), Response::HTTP_NOT_FOUND);
  }

  public function internalServerError(): Response
  {
    return $this->display(new View('./DemoController/internalServerError', array(
      'title' => '500'
    )), Response::HTTP_INTERNAL_SERVER_ERROR);
  }
}
