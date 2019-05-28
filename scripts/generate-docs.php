<?php

define('PATH_BASE', realpath(dirname(__FILE__).'/..'));
define('PATH_CORE', realpath(PATH_BASE.'/core'));
define('PATH_PACKAGES', realpath(PATH_BASE.'/packages'));
define('PATH_CACHE', realpath(PATH_BASE.'/cache'));
define('PATH_VENDOR', realpath(PATH_BASE.'/vendor'));

require(PATH_VENDOR.'/autoload.php');
require(PATH_BASE.'/autoload.php');

use Sami\Sami;
use Symfony\Component\Finder\Finder;

echo 'Generating docs';

$iterator = Finder::create()
	->files()
	->name('*.php')
	->in(PATH_CORE);

$sami = new Sami($iterator, array(
	'theme' => 'default',
	'versions' => 'master',
	'title' => 'Phoxx API',
	'build_dir' => PATH_BASE.'/docs',
	'cache_dir' => PATH_CACHE.'/sami'
));

$sami['project']->update(null, true);