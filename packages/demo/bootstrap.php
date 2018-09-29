<?php

use Phoxx\Core\Router\Router;
use Phoxx\Core\Package\Package;

/**
 * Load package routes.
 */
foreach (Package::getInstance('demo')->config()->getFile('routes') as $method => $route) {
	foreach ($route as $path => $action) {
		Router::core()->setRoute($path, $action, $method);
	}
}