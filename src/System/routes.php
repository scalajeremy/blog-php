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
  'adm_dashboard' => 'Admin Dashboard',
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

// ADMIN ROUTES

$app->get('/adm_dashboard', function (Request $request, Response $response, array $args) {
    global $twig;
    $args['pagename'] = 'Dashboard';
    return $response->getBody()->write($twig->render('adm_dashboard.twig', $args));
})->setName('adm_dashboard');

$app->get('/adm_articles', function (Request $request, Response $response, array $args) {
    global $twig;
    $args['pagename'] = 'Articles';
    $sql ='SELECT title, author, content FROM articles';
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    $args['article'] = $stmt;
    return $response->getBody()->write($twig->render('adm_articles.twig', $args));
})->setName('adm_articles');

$app->get('/adm_add_articles', function (Request $request, Response $response, array $args) {
    global $twig;
    $args['pagename'] = 'Add/Edit Articles';
    return $response->getBody()->write($twig->render('adm_add_articles.twig', $args));
})->setName('adm_add_articles');

$app->get('/adm_cat', function (Request $request, Response $response, array $args) {
    global $twig;
    $args['pagename'] = 'Add/Edit Category';
    return $response->getBody()->write($twig->render('adm_cat.twig', $args));
})->setName('adm_cat');

$app->get('/adm_media', function (Request $request, Response $response, array $args) {
    global $twig;
    $args['pagename'] = 'Add/Edit Media';
    return $response->getBody()->write($twig->render('adm_media.twig', $args));
})->setName('adm_media');

$app->get('/adm_users', function (Request $request, Response $response, array $args) {
    global $twig;
    $args['pagename'] = 'Add/Edit Users';
    return $response->getBody()->write($twig->render('adm_users.twig', $args));
})->setName('adm_users');


$app->get('/{pagename}', function (Request $request, Response $response, array $args) {
    global $twig;
    $route = $args['pagename'];
    $this->logger->info("Slim route: '/$route'");

    // Render index view
    return $response->getBody()->write($twig->render('home.twig', $args));
});
