<?php

namespace Phoxx\Controllers;

use Phoxx\Core\Controllers\Helpers\FrontController;
use Phoxx\Core\Http\Response;
use Phoxx\Core\Renderer\View;

class DemoController extends FrontController
{
  public function index(): Response
  {
    return $this->render(new View('./DemoController/index', [
      'title' => 'Home'
    ]));
  }

  public function pageNotFound(): Response
  {
    return $this->render(new View('./DemoController/pageNotFound', [
      'title' => '404'
    ]), Response::HTTP_NOT_FOUND);
  }

  public function internalServerError(): Response
  {
    return $this->render(new View('./DemoController/internalServerError', [
      'title' => '500'
    ]), Response::HTTP_INTERNAL_SERVER_ERROR);
  }
}
