<?php

define('PATH_BASE', realpath(dirname(__FILE__).'/..'));
define('PATH_CORE', realpath(PATH_BASE.'/core'));
define('PATH_PACKAGES', realpath(PATH_BASE.'/packages'));
define('PATH_CACHE', realpath(PATH_BASE.'/cache'));
define('PATH_VENDOR', realpath(PATH_BASE.'/vendor'));

require(PATH_VENDOR.'/autoload.php');
require(PATH_BASE.'/autoload.php');

use Phoxx\Core\Database\Migrator;
use Phoxx\Core\Database\Exceptions\MigrationException;

echo 'Migrating package(s)';

array_shift($argv);

if (count($argv) === 0) {
	echo PHP_EOL.'ERROR: Please define package to migrate';
	exit;
}

$migrator = new Migrator();

foreach ($argv as $package) {
	$package = strtolower($package);

	if (file_exists(PATH_PACKAGES.'/'.$package) === false) {
		echo PHP_EOL.'ERROR: Invalid package defined';
		exit;
	}

	$namespace = 'Phoxx\\Packages\\'.$package.'\\Migrations';
	$dir = PATH_PACKAGES.'/'.$package.'/classes/Migrations';

	/**
	 * Load potential migrations.
	 */
	foreach (scandir($dir) as $file) {
		if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
			include($dir.'/'.$file);
		}
	}

	/**
	 * Loop loaded classes to find potential migrations.
	 */
	foreach (get_declared_classes() as $class) {
		if (substr(strtolower($class), 0, strlen($namespace)) === strtolower($namespace)) {
			try {
				echo PHP_EOL.'Migrating class `'.$class.'`';
				$migrator->up(new $class());
			} catch (MigrationException $e) {
				echo PHP_EOL.'ERROR: Failed to migrate class `'.$class.'`';
				exit;
			}
		}
	}
}