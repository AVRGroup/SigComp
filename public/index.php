<?php
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

// Run!
$app->run();