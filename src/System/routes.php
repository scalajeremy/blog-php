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
  'signup' => 'Signup',
]);

$app->get('/', function (Request $request, Response $response) {
    global $twig;
    $args['pagename'] = 'Home';
    return $response->getBody()->write($twig->render('home.twig', $args));
})->setName('home');

$app->get('/home', function (Request $request, Response $response){
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

$app->get('/signup', function (Request $request, Response $response, array $args) {
    global $twig;
    $args['pagename'] = 'Signup';
    return $response->getBody()->write($twig->render('signup.twig', $args));
})->setName('signup');

$app->post('/login', function(Request $request,Response $response, $args) {
    $password = $request->getParam('password');
    $username = $request->getParam('username');
    $sql = 'SELECT * FROM users WHERE username = :username';
    $stmt= $this->db->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->execute([$username]);
    $result = $stmt->fetchAll();

    if (!password_verify($password, $result[0]['passwd'])) {
        echo "Nop try again";
        return $this->view->render($response, 'login.twig');
    } else {
        session_start();
        $_SESSION['id'] = $fetch['id'];
        $_SESSION['username'] = $username;
        echo "Welcome " . $username . " !";
        return $this->view->render($response, 'home.twig');
    }
})->setName('login');

$app->post('/signup', function(Request $request,Response $response, $args) {
    $firstname = $request->getParam('firstname');
    $lastname = $request->getParam('lastname');
    $email = $request->getParam('email');
    $username = $request->getParam('username');
    $password = password_hash($request->getParam('password'),PASSWORD_BCRYPT, ['cost' => 10]);
    try{
        $sql = 'INSERT INTO users (last_name, first_name, username, passwd, email, permission_lvl)
        VALUES (:last_name, :first_name, :username, :passwd, :email, 0)';
        $stmt= $this->db->prepare($sql);
        $stmt->bindValue(':last_name', $lastname);
        $stmt->bindValue(':first_name', $firstname);
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':passwd', $password);
        $stmt->bindValue(':email', $email);
        $stmt->execute(array($lastname, $firstname, $username, $password, $email));
        return $this->view->render($response, 'login.twig');
    }
    catch(Exception $e){
        var_dump($e->getMessage());
        return $this->view->render($response, 'signup.twig');
    }

})->setName('signup');

$app->get('/{pagename}', function (Request $request, Response $response, array $args) {
    global $twig;
    $route = $args['pagename'];
    $this->logger->info("Slim route: '/$route'");

    // Render index view
    return $response->getBody()->write($twig->render('home.twig', $args));
});
