<?php
error_reporting(E_ALL);
ini_set('display_errors', 'on');

use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\Configuration;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;

require("Documents\Doc.php");

if ( ! file_exists($file = __DIR__.'/vendor/autoload.php')) {
    throw new RuntimeException('Install dependencies to run this script.');
}

$loader = require_once $file;

$loader->add('Documents', __DIR__);

$connection = new Connection();
$config = new Configuration();

$config->setProxyDir(__DIR__ . '/Proxies');
$config->setProxyNamespace('Proxies');
$config->setHydratorDir(__DIR__ . '/Hydrators');
$config->setHydratorNamespace('Hydrators');
$config->setDefaultDB('stack_test');

$config->setMetadataDriverImpl(AnnotationDriver::create(__DIR__ . '/Documents'));
AnnotationDriver::registerAnnotationClasses();

$dm = DocumentManager::create($connection, $config);

$app=new \Slim\App([
    'settings'=>[
        'displayErrorDetails'=>true,
    ]
]);
?>