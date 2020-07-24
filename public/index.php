<?php

/**
 * Phoxx MVC - Init.
 *
 * @package phoxx-mvc
 * @author  Aiden Foxx <aiden@foxx.io>
 */
use Phoxx\Core\Framework\Application;
use Phoxx\Core\Http\Helpers\SimpleRequest;
use Phoxx\Core\Http\Response;

define('PATH_BASE', realpath(__DIR__.'/..'));
define('PATH_CACHE', realpath(PATH_BASE.'/cache'));
define('PATH_VENDOR', realpath(PATH_BASE.'/vendor'));
define('PATH_PUBLIC', realpath(PATH_BASE.'/public'));

/**
 * Register application.
 */
$bootstrap = [];

function register_bootstrap(callable $callback) {
  global $bootstrap;
  $bootstrap[] = $callback;
}

require PATH_VENDOR.'/autoload.php';

/**
 * Initialize application.
 */
$application = new Application();

error_reporting(0);

set_exception_handler(function () use ($application) {
  http_response_code(500);

  if (($response = $application->dispatch(new SimpleRequest('_500_'))) instanceof Response) {
    $application->send($response);
    exit;
  }

  echo '<h1>Error 500</h1><p>An unknown error has occured.</p>';
});

foreach ($bootstrap as $callback) {
  $callback($application);
}

/**
 * Dispatch request.
 */
if (($response = $application->dispatch(new SimpleRequest($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']))) instanceof Response) {
  $application->send($response);
  exit;
}

http_response_code(404);

if (($response = $application->dispatch(new SimpleRequest('_404_'))) instanceof Response) {
  $application->send($response);
  exit;
}

echo '<h1>Error 404</h1><p>The requested page could not be found.</p>';
