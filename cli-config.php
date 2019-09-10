<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

use Doctrine\ORM\Tools\Console\ConsoleRunner;

$settings = require __DIR__ . '/app/settings.php';
$settings = $settings['settings'];

$config = new \Doctrine\ORM\Configuration();
$config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
$driverImpl = new \Doctrine\ORM\Mapping\Driver\AnnotationDriver(new \Doctrine\Common\Annotations\AnnotationReader(), $settings['doctrine']['model']);
\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');
$config->setMetadataDriverImpl($driverImpl);
$config->setQueryCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
$config->setProxyDir($settings['doctrine']['cache_proxy']);
$config->setProxyNamespace('App\Cache\Proxies');

$config->setAutoGenerateProxyClasses(true);

$em = \Doctrine\ORM\EntityManager::create($settings['db'], $config);


return ConsoleRunner::createHelperSet($em);
