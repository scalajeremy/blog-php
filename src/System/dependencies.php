<?php
// load all the containers
use Psr\Container\ContainerInterface;
use App\Models\User;
use App\Models\Article;
use App\Models\Categorie;

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
    $view->getEnvironment()->addGlobal('session', $_SESSION);

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

// container to connect to the db
$container['db'] = function (ContainerInterface $container) {
    $cf = $container['database'];
    $pdo = new PDO($cf['driver'].':host=' . $cf['host'].';port='.$cf['port'].';dbname='.$cf['database'], $cf['username'], $cf['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

//container for user class
$container['user'] = function (ContainerInterface $container) {
    return new User($container);
};

//container for article class
$container['article'] = function (ContainerInterface $container){
    return new Article($container);
};

//container for categorie class
$container['categorie'] = function (ContainerInterface $container){
    return new Categorie($container);
};
