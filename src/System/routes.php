<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes

$loader = new \Twig\Loader\FilesystemLoader('../templates');
$twig = new \Twig\Environment($loader);
$twig->addGlobal('router', $app->getContainer()->get('router'));
$twig->addGlobal('navbar', [
  'home' => 'Home',
  'login' => 'Login',
  'team' => 'Team',
  'articles' => 'Articles',
  'signin' => 'SignIn',
]);

$app->get('/', function (Request $request, Response $response) {
    global $twig;
    $args['pagename'] = 'Home';
    return $response->getBody()->write($twig->render('home.twig', $args));
})->setName('home');

$app->get('/login', function (Request $request, Response $response, array $args) {
    global $twig;
    $args['pagename'] = 'Login';
    return $response->getBody()->write($twig->render('login.twig', $args));
})->setName('login');

$app->get('/team', function (Request $request, Response $response, array $args) {
    global $twig;
    $args['pagename'] = 'Team';
    return $response->getBody()->write($twig->render('team.twig', $args));
})->setName('team');

$app->get('/articles', function (Request $request, Response $response, array $args) {
    global $twig;
    $args['pagename'] = 'Articles';
    return $response->getBody()->write($twig->render('articles.twig', $args));
})->setName('articles');

$app->get('/signin', function (Request $request, Response $response, array $args) {
    global $twig;
    $args['pagename'] = 'SignIn';
    return $response->getBody()->write($twig->render('signin.twig', $args));
})->setName('signin');




$app->get('/{pagename}', function (Request $request, Response $response, array $args) {
    global $twig;
    $route = $args['pagename'];
    $this->logger->info("Slim route: '/$route'");

    // Render index view
    return $response->getBody()->write($twig->render('home.twig', $args));
});
