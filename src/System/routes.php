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
  'about' => 'About',
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

$app->get('/about', function (Request $request, Response $response, array $args) {
    global $twig;
    $args['pagename'] = 'About';
    return $response->getBody()->write($twig->render('about.twig', $args));
})->setName('about');

$app->post('/login', function(Request $request,Response $response, $args) {
  $password = $request->getParam('password');
  $username = $request->getParam('username');
  $sql = 'SELECT * FROM users WHERE username = ?';
  $stmt= $this->db->prepare($sql);
  $stmt->execute([''.$username]);
  $result = $stmt->fetchAll();

  if ($password != $result[0]['passwd']) {
    echo "Nique ta grand-mère en jet-ski";
    return $this->view->render($response, 'login.twig');
  } else {
      session_start();
      $_SESSION['id'] = $fetch['id'];
      $_SESSION['username'] = $username;
      echo "Vous êtes un Beau Gosse";
      return $this->view->render($response, 'home.twig');
    }
})->setName('login');



$app->get('/{pagename}', function (Request $request, Response $response, array $args) {
    global $twig;
    $route = $args['pagename'];
    $this->logger->info("Slim route: '/$route'");

    // Render index view
    return $response->getBody()->write($twig->render('home.twig', $args));
});
