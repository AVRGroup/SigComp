<?php
define('IN_MYBB', NULL);
global $mybb, $lang, $query, $db, $cache, $plugins, $displaygroupfields;
require_once 'myBB/global.php';
require_once 'MyBBIntegrator.php';
$MyBBI = new MyBBIntegrator($mybb, $db, $cache, $plugins, $lang, $config);

date_default_timezone_set('America/Sao_Paulo');
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

session_start();

// Set up dependencies Instantiate the app
require  __DIR__ . '/../app/Container.php';
$settings = require __DIR__ . '/../app/settings.php';
$app = new \Slim\App(new Container($settings));

// Register routes
require __DIR__ . '/../app/routes.php';

//$MyBBI->login('projeto', 'prj#game');


// Run!
$app->run();