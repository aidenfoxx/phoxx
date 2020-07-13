<?php

use Phoxx\Core\Framework\Application;
use Phoxx\Core\Router\Route;

if (!function_exists('register_bootstrap')) {
  return;
}

/**
* Bootstrap application.
*/
register_bootstrap(function(Application $application) {
  $config = $application->getServiceContainer()->getService('Phoxx\Core\Utilities\Config');

  /**
   * Load and register routes from config.
   */
  foreach ($config->getFile('routes') as $pattern => $action) {
    $application->getRouteContainer()->addRoute(new Route($pattern, $action));
  }
});
