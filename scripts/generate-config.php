<?php

define('PATH_BASE', realpath(dirname(__FILE__).'/..'));
define('PATH_CORE', realpath(PATH_BASE.'/core'));

echo 'Generating config files';

if (file_exists(PATH_CORE.'/config/cache') === false) {
	mkdir(PATH_CORE.'/config/cache');
}

copy(PATH_BASE.'/scripts/config/cache/memcached.php', PATH_CORE.'/config/cache/memcached.php');
copy(PATH_BASE.'/scripts/config/cache/redis.php', PATH_CORE.'/config/cache/redis.php');
copy(PATH_BASE.'/scripts/config/core.php', PATH_CORE.'/config/core.php');
copy(PATH_BASE.'/scripts/config/database.php', PATH_CORE.'/config/database.php');
copy(PATH_BASE.'/scripts/config/packages.php', PATH_CORE.'/config/packages.php');
copy(PATH_BASE.'/scripts/config/renderer.php', PATH_CORE.'/config/renderer.php');