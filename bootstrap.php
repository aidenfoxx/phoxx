<?php

use Phoxx\Core\Framework\Application;
use Phoxx\Core\Router\Route;
use Phoxx\Core\Utilities\Config;

if (!function_exists('register_bootstrap')) {
  return;
}

/**
* Bootstrap application.
*/
register_bootstrap(function(Application $application) {
  $config = $application->getServiceContainer()->getService(Config::class);

  /**
   * Load and register routes from config.
   */
  foreach ($config->getFile('routes') as $pattern => $action) {
    $application->getRouteContainer()->addRoute(new Route($pattern, $action));
  }
});
