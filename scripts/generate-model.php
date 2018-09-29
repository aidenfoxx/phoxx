<?php

define('PATH_BASE', realpath(dirname(__FILE__).'/..'));
define('PATH_CORE', realpath(PATH_BASE.'/core'));

require PATH_VENDOR.'/autoload.php';
require PATH_BASE.'/autoload.php';

use Doctrine\ORM\Events;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Tools\DisconnectedClassMetadataFactory;
use Doctrine\ORM\Tools\Export\ClassMetadataExporter;
use Doctrine\ORM\Mapping\Driver\DatabaseDriver;
use Doctrine\ORM\Tools\Export\ExportException;

use Phoxx\Core\Utilities\Config;

echo 'Generating database model';

$namespace = 'Phoxx\\Core\\Models\\';
$tables = array();

/**
 * Define parameters for core or package
 * model generation.
 */
while ($parameter = next($argv)) {	
	if ($parameter == '--package' || $parameter == '-p') {
		$package = next($argv);
		if ((bool)$package !== false) {
			$namespace = 'Phoxx\\Packages\\'.ucfirst($package).'\\Models\\';
		}
	} else {
		$tables[] = array(
			'name' => $parameter,
			'class' => ''
		);
	}
}

if (empty($tables) === false) {
	foreach ($tables as $key => $table) {
		foreach (explode('_', $tables[$key]['name']) as $component) {
			$tables[$key]['class'] .= ucfirst($component);
		}
	}
} else {
	echo 'ERROR: Please define table to generate model';
	exit;
}

$config = Config::getInstance()->getFile('database');
$doctrineConfig = Setup::createAnnotationMetadataConfiguration(array(), false);

try {
	$entityManager = EntityManager::create(array(
		'dbname' => $config->DATABASE_NAME,
		'user' => $config->DATABASE_USER,
		'password' => $config->DATABASE_PASSWORD,
		'host' => $config->DATABASE_HOST,
		'port' => $config->DATABASE_PORT,
		'driver'   => 'pdo_mysql'
	), $doctrineConfig);
	$entityManager->getConnection()->connect();
} catch (Exception $e) {
	echo 'ERROR: Could not establish database connection';
	exit;
}

$databaseDriver = new DatabaseDriver($entityManager->getConnection()->getSchemaManager());
$databaseDriver->setNamespace($namespace);

$entityManager->getConfiguration()->setMetadataDriverImpl($databaseDriver);

$metadataFactory = new DisconnectedClassMetadataFactory();
$metadataFactory->setEntityManager($entityManager);

$metadata = array();

foreach ($tables as $table) {
	try {
		$metadata[] = $metadataFactory->getMetadataFor($namespace.$table['class']);
	} catch (InvalidArgumentException $e) {
		echo 'ERROR: Unknown table `'.$table['name'].'`';
		exit;
	}
}

$metadataExporter = new ClassMetadataExporter();

try {
	$exporter = $metadataExporter->getExporter('xml', PATH_BASE.'/scripts/models');
	$exporter->setMetadata($metadata);
	$exporter->export();
} catch (ExportException $e) {
	echo 'ERROR: Export failed. Ensure the file does not already exist';
	exit;
}