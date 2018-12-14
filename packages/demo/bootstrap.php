<?php

use Phoxx\Core\Router\Router;
use Phoxx\Core\Package\Package;

/**
 * Load package routes.
 */
foreach (Package::getInstance('demo')->getConfig()->getFile('routes') as $method => $route) {
	foreach ($route as $path => $action) {
		Router::getCore()->addRoute($path, $action, $method);
	}
}