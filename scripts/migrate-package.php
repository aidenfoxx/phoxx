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

if (count($argv) > 0) {
	foreach ($argv as $package) {
		if (file_exists(PATH_PACKAGES.'/'.$package) === true) {
			$namespace = 'Phoxx\\Packages\\'.strtolower($package).'\\Migrations';
			$migrations = PATH_PACKAGES.'/'.$package.'/classes/migrations';

			/**
			 * Load potential migrations.
			 */
			foreach (scandir($migrations) as $file) {
				if (substr($file, -4) === '.php') {
					include($migrations.'/'.$file);
				}
			}

			/**
			 * Loop loaded classes to find potential migrations.
			 */
			foreach (get_declared_classes() as $class) {
				if (substr(strtolower($class), 0, strlen($namespace)) === strtolower($namespace)) {
					try {
						$migration = new $class();
						echo PHP_EOL.'Migrating class `'.$class.'`';
						Migrator::getCore()->up($migration);
					} catch (MigrationException $e) {
						echo PHP_EOL.'ERROR: Failed to migrate class `'.$class.'`';
						exit;
					}
				}
			}
		} else {
			echo PHP_EOL.'ERROR: Invalid package defined';
			exit;
		}
	}
	exit;
}
echo PHP_EOL.'ERROR: Please define package to migrate';