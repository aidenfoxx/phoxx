<?php

define('PATH_BASE', realpath(dirname(__FILE__).'/..'));
define('PATH_CORE', realpath(PATH_BASE.'/core'));
define('PATH_PACKAGES', realpath(PATH_BASE.'/packages'));
define('PATH_CACHE', realpath(PATH_BASE.'/cache'));
define('PATH_VENDOR', realpath(PATH_BASE.'/vendor'));

require(PATH_VENDOR.'/autoload.php');
require(PATH_BASE.'/autoload.php');

use Doctrine\ORM\Events;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\Tools\DisconnectedClassMetadataFactory;
use Doctrine\ORM\Tools\Export\ClassMetadataExporter;
use Doctrine\ORM\Mapping\Driver\DatabaseDriver;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\Tools\Export\ExportException;

use Phoxx\Core\Utilities\Config;

function generateClassName($class) {
	$className = '';
	foreach (explode('_', $class) as $component) {
		$className .= ucfirst($component);
	}
	return $className;
}

function removePrefix($name, $prefix) {
	if (($prefixLength = strlen($prefix)) > 0 && strncmp($name, $prefix, $prefixLength) === 0) {
		return substr($name, $prefixLength);
	}
	return $name;
}

echo 'Generating database model(s)';

$namespace;
$tables = array();
$config = Config::getCore()->getFile('database');


$tablePrefix = $config->DATABASE_PREFIX;
$classPrefix = generateClassName($tablePrefix);

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
			'table_name' => $parameter,
			'class_name' => generateClassName($parameter)
		);
	}
}

/**
 * Check we have table to generate models.
 */
if (empty($tables) === false) {
	/**
	 * Check we have a valid namespace.
	 */
	if (isset($namespace) === true) {
		try {
			$doctrineConfig = Setup::createAnnotationMetadataConfiguration(array(), true);
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
			echo PHP_EOL.'ERROR: Could not establish database connection';
			exit;
		}

		$databaseDriver = new DatabaseDriver($entityManager->getConnection()->getSchemaManager());
		$databaseDriver->setNamespace($namespace);

		$entityManager->getConfiguration()->setMetadataDriverImpl($databaseDriver);

		$metadataFactory = new DisconnectedClassMetadataFactory();
		$metadataFactory->setEntityManager($entityManager);

		$metadata = array();

		/**
		 * Generate metadata to export.
		 */
		foreach ($tables as $table) {
			try {
				$classMetadata = $metadataFactory->getMetadataFor($namespace.$table['class_name']);

				/**
				 * Remove prefix from model data.
				 */
				$classMetadata->name = $namespace.removePrefix($table['class_name'], $classPrefix);
				$classMetadata->rootEntityName = $namespace.removePrefix($table['class_name'], $classPrefix);
				$classMetadata->table['name'] = removePrefix($table['table_name'], $tablePrefix);;

				/**
				 * Remove prefix from associations.
				 */
				foreach ($classMetadata->getAssociationMappings() as $fieldName => $mapping) {
					$targetEntityData = explode('\\', $mapping['targetEntity']);
					$sourceEntityData = explode('\\', $mapping['sourceEntity']);

					$targetEntityData[] = removePrefix(array_pop($targetEntityData), $classPrefix);
					$sourceEntityData[] = removePrefix(array_pop($sourceEntityData), $classPrefix);

					$classMetadata->associationMappings[$fieldName]['targetEntity'] = implode('\\', $targetEntityData);
					$classMetadata->associationMappings[$fieldName]['sourceEntity'] = implode('\\', $sourceEntityData);

					if ($mapping['type'] === ClassMetadataInfo::MANY_TO_MANY && $mapping['isOwningSide'] === true) {
						$classMetadata->associationMappings[$fieldName]['joinTable']['name'] = removePrefix($mapping['joinTable']['name'], $tablePrefix);
					}
				}

				$metadata[] = $classMetadata;
			} catch (InvalidArgumentException $e) {
				echo PHP_EOL.'ERROR: Unknown table `'.$table['table_name'].'`';
				exit;
			}
		}

		/**
		 * Export mappings.
		 */
		$metadataExporter = new ClassMetadataExporter();

		try {
			$exporter = $metadataExporter->getExporter('xml', PATH_BASE.'/scripts/models');
			$exporter->setMetadata($metadata);
			$exporter->export();
		} catch (ExportException $e) {
			echo PHP_EOL.'ERROR: Export failed. Ensure the file does not already exist';
		}
		
		exit;
	}
	echo PHP_EOL.'ERROR: Package undefined';
	exit;
}
echo PHP_EOL.'ERROR: No table(s) defined';