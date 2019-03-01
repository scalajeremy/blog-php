<?php
// load all the containers
use Psr\Container\ContainerInterface;

$container = $app->getContainer();

// set the new ones => we pass the container as param to have access to the others

// twig
$container['view'] = function(ContainerInterface $container){
    $view = new \Slim\Views\Twig($container['settings']['twig']['views'], [
        'cache' => $container['settings']['twig']['cache']
    ]);

    // Instantiate and add Slim specific extension
    $router = $container->get('router');
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));

    $view->getEnvironment()->addGlobal('session', $_SESSION ?? false);
    $view->getEnvironment()->addGlobal('role', false);

    $filter = new Twig_SimpleFilter('rot13', function($string){
        return str_rot13($string);
    });

    $view->getEnvironment()->addFilter($filter);
    // {{ monString | rot13 }}

    $function = new Twig_SimpleFunction('assets', [$this, 'bar']);
    $view->getEnvironment()->addFunction($function);

    // {{ assets() }}
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
// $container['db'] = function (ContainerInterface $container) {
//     $capsule = new \Illuminate\Database\Capsule\Manager;
//     $capsule->addConnection($container['settings']['database']);
//     $capsule->setAsGlobal();
//     $capsule->bootEloquent();
//     return $capsule;
// };

// PDO database library
$container['db'] = function ($container) {
    $cf = $container->get('settings')['db'];
    $pdo = new PDO($cf['driver'] .':host=' . $cf['host'] . ';port=' . $cf['port'] . ';
      dbname=' . $cf['dbname'], $cf['user'], $cf['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

$container['post'] = function($container) {
    return new App\Models\Post($container);
};

$container['user'] = function($container) {
    return new App\Models\User($container);
};

$container['article'] = function($container){
    return new App\Models\Article($container);
};

$container['categorie'] = function($container){
    return new App\Models\Categorie($container);
};