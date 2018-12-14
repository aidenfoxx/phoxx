<?php

$classmap = array();

/**
 * Load cached classmap.
 */
if (file_exists(PATH_CACHE.'/classmap.php') === true) {
	$classmap = include(PATH_CACHE.'/classmap.php');

	/**
	 * If classmap doesn't exist, or is not a valid array,
	 * set to array.
	 */
	if (is_array($classmap) === false) {
		$classmap = array();
	}
}

/**
 * Core autoloader for Phoxx MVC.
 */
spl_autoload_register(function(string $class) {
	global $classmap;

	if (isset($classmap[$class]) === true) {
		include($classmap[$class]['path']);
	} else {
		$path = explode('\\', strtolower($class));
		$namespace = array_shift($path);
		
		if ($namespace === 'phoxx') {
			$location = array_shift($path);

			if ($location === 'core') {
				$file = realpath(PATH_CORE.'/classes/'.implode('/', $path).'.php');
			} else if ($location === 'packages') {
				$package = array_shift($path);
				$file = realpath(PATH_PACKAGES.'/'.$package.'/classes/'.implode('/', $path).'.php');
			}

			if (isset($file) === true && file_exists($file) === true) {
				$classmap[$class] = array('path' => $file, 'timestamp' => time());
				include($file);
			}
		}
	}
});

/**
 * Cache classmap for future use.
 */
register_shutdown_function(function() {
	global $classmap;
	file_put_contents(PATH_CACHE.'/classmap.php', '<?php return '.var_export($classmap, true).';');
});