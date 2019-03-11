<?php
session_start();
require dirname(__DIR__).'/vendor/autoload.php';

// loads the settings dependence
$settings = require dirname(__DIR__) . '/src/System/settings.php';


// lets init the Slim instance
$app = new \Slim\App($settings);

// import the files
require dirname(__DIR__).'/src/System/dependencies.php';
require dirname(__DIR__).'/src/System/middlewares.php';
require dirname(__DIR__).'/src/System/routes.php';

$app->run();