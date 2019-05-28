<?php

define('PATH_BASE', realpath(__DIR__.'/..'));
define('PATH_CORE', realpath(PATH_BASE.'/core'));
define('PATH_PACKAGES', realpath(PATH_BASE.'/packages'));
define('PATH_CACHE', realpath(PATH_BASE.'/cache'));
define('PATH_VENDOR', realpath(PATH_BASE.'/vendor'));
define('PATH_PUBLIC', '');

define('DS', DIRECTORY_SEPARATOR);

require(PATH_VENDOR.'/autoload.php');
require(PATH_BASE.'/autoload.php');
require(PATH_CORE.'/bootstrap.php');