<?php

return [
  /**
   * Home route.
   */
  '' => ['Phoxx\Controllers\DemoController' => 'index'],

  /**
   * 404 route.
   */
  '_404_' => ['Phoxx\Controllers\DemoController' => 'pageNotFound'],

  /**
   * 500 route.
   */
  '_500_' => ['Phoxx\Controllers\DemoController' => 'internalServerError'],
];
