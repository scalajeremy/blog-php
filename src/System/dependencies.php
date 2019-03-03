<?php
// load all the containers
use Psr\Container\ContainerInterface;

$container = $app->getContainer();


// set the new ones => we pass the container as param to have access to the others

// twig
$container['view'] = function($container){
    $view = new \Slim\Views\Twig(dirname(__DIR__).'/View', [
        'cache' => false,
        'debug' => true
    ]);

    // Instantiate and add Slim specific extension
    $router = $container['router'];

    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));

    return $view;
};

// monolog
$container['logger'] = function(ContainerInterface $container) {

    // this gives the name of your monolog alias
    $logger = new \Monolog\Logger('app_logger');

    // monolog channel debug gets all
    $debug = new \Monolog\Handler\StreamHandler(dirname(__DIR__).'/src/logs/debug.'.date('Y-m-d').'.log');
    $logger->pushHandler($debug);

    // monolog channel error gets the errors
    $errors = new \Monolog\Handler\StreamHandler(dirname(__DIR__).'/src/logs/error.'.date('Y-m-d').'.log', $logger::ERROR);
    $logger->pushHandler($errors);

    // methods debug() info() notice() warning() error() warning()
    return $logger;
};

// Service factory for the ORM :: eloquent / laravel's ORM
$container['db'] = function (ContainerInterface $container) {
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($container['settings']['database']);
    $capsule->setAsGlobal();
    $capsule->bootEloquent();
    return $capsule;
};


