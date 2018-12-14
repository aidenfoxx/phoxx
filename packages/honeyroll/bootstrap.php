<?php

use Phoxx\Core\Router\Router;
use Phoxx\Core\Package\Package;
use Phoxx\Core\Renderer\Renderer;
use Phoxx\Core\Renderer\Drivers\TwigDriver;

/**
 * Ensure core is compatible with package.
 */
if ((Renderer::getCore()->getDriver() instanceof TwigDriver) === false) {
	throw new Exception('Package `honeysnap` supports only Twig as the core renderer.');
}

/**
 * Load package routes.
 */
foreach (Package::getInstance('honeyroll')->getConfig()->getFile('routes') as $method => $route) {
	foreach ($route as $path => $action) {
		Router::getCore()->addRoute($path, $action, $method);
	}
}