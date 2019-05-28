<?php

use Phoxx\Core\Framework\Application;
use Phoxx\Core\Framework\Exceptions\ServiceException;

if (($config = Application::getInstance('core')->getService('config')) === null) {
	throw new ServiceException('Cannot find `config` service.');
}

$router = Application::getInstance('core')->getRouter();

/**
 * Load package routes.
 */
foreach ($config->getFile('@demo/routes') as $method => $route) {
	foreach ($route as $path => $action) {
		$router->setRoute($path, $action, $method);
	}
}