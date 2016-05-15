<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
require_once 'bootstrap.php';

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$config->setAutoGenerateProxyClasses(true);
$entityManager = EntityManager::create($dbParams, $config);
return ConsoleRunner::createHelperSet($entityManager);

