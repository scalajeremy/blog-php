<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader);
$twig->addGlobal('router', $app->getContainer()->get('router'));
$twig->addGlobal('navbar', [
  'home' => 'Home',
  'champs' => 'Champions',
  'login' => 'Login',
  'about' => 'About',
]);

$app->get('/', function (Request $request, Response $response) {
    global $twig;
    $args['pagename'] = 'Home';
    return $response->getBody()->write($twig->render('home.twig', $args));
})->setName('home');

$app->get('/champs', function (Request $request, Response $response, array $args) {
    global $twig;
    $args['pagename'] = 'Champions';

    $PDO = new PDO('pgsql:host=localhost;dbname=test', 'root', 'root');
    //$PDO = new PDO('pgsql:host=localhost;port=5432;dbname=test;user=root;password=root');
    $champs = $PDO->query('SELECT champ_name, price_BE, price_RP, lore, main_position, sub_position FROM champions')->fetchAll(PDO::FETCH_ASSOC);
    $args['champs'] = $champs;

    // Render index view
    return $response->getBody()->write($twig->render('champs.twig', $args));
})->setName('champs');

$app->get('/login', function (Request $request, Response $response, array $args) {
    global $twig;
    $args['pagename'] = 'Login';
    return $response->getBody()->write($twig->render('login.twig', $args));
})->setName('login');


$app->get('/about', function (Request $request, Response $response, array $args) {
    global $twig;
    $args['pagename'] = 'About';
    return $response->getBody()->write($twig->render('about.twig', $args));
})->setName('about');



$app->get('/{pagename}', function (Request $request, Response $response, array $args) {
    global $twig;
    $route = $args['pagename'];
    $this->logger->info("Slim route: '/$route'");

    // Render index view
    return $response->getBody()->write($twig->render('home.twig', $args));
});
