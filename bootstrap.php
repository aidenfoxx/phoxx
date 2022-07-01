<?php

use Phoxx\Core\Http\Router;
use Phoxx\Core\System\Services;
use Phoxx\Core\System\Config;

if (!function_exists('register_bootstrap')) {
  return;
}

/**
* Bootstrap application.
*/
register_bootstrap(function (Router $router, Services $services) {
  $config = $serviceContainer->getService(Config::class);

  /**
   * Load and register routes from config.
   */
  foreach ($config->open('routes') as $pattern => $action) {
    $router->register(new Route($pattern, $action));
  }
});
