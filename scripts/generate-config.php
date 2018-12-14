<?php

define('PATH_BASE', realpath(dirname(__FILE__).'/..'));
define('PATH_CORE', realpath(PATH_BASE.'/core'));
define('PATH_PACKAGES', realpath(PATH_BASE.'/packages'));
define('PATH_CACHE', realpath(PATH_BASE.'/cache'));
define('PATH_VENDOR', realpath(PATH_BASE.'/vendor'));

echo 'Generating config files';

if (file_exists(PATH_CORE.'/config/cache') === false) {
	mkdir(PATH_CORE.'/config/cache');
}

if (file_exists(PATH_CORE.'/config/mailer') === false) {
	mkdir(PATH_CORE.'/config/mailer');
}

if (file_exists(PATH_CORE.'/config/renderer') === false) {
	mkdir(PATH_CORE.'/config/renderer');
}

copy(PATH_BASE.'/scripts/config/cache/memcached.php', PATH_CORE.'/config/cache/memcached.php');
copy(PATH_BASE.'/scripts/config/cache/redis.php', PATH_CORE.'/config/cache/redis.php');
copy(PATH_BASE.'/scripts/config/mailer/smtp.php', PATH_CORE.'/config/mailer/smtp.php');
copy(PATH_BASE.'/scripts/config/renderer/smarty.php', PATH_CORE.'/config/renderer/smarty.php');
copy(PATH_BASE.'/scripts/config/renderer/twig.php', PATH_CORE.'/config/renderer/twig.php');
copy(PATH_BASE.'/scripts/config/core.php', PATH_CORE.'/config/core.php');
copy(PATH_BASE.'/scripts/config/database.php', PATH_CORE.'/config/database.php');
copy(PATH_BASE.'/scripts/config/packages.php', PATH_CORE.'/config/packages.php');