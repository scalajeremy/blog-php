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
  'adm_dashboard' => 'Admin Dashboard'
]);

$app->get('/', function (Request $request, Response $response) {
    global $twig;
    $args['pagename'] = 'Home';
    return $this->view->render($response, 'home.twig');
})->setName('home');

$app->get('/home', function (Request $request, Response $response){
    return $response->withRedirect('/', 301);
})->setName('home');

$app->get('/login', function (Request $request, Response $response, array $args) {
    global $twig;
    $args['pagename'] = 'Login';
    return $this->view->render($response, 'login.twig');
})->setName('login');

$app->get('/team', function (Request $request, Response $response, array $args) {
    global $twig;
    $args['pagename'] = 'Team';
    return $this->view->render($response, 'team.twig');
})->setName('team');

$app->get('/articles', function (Request $request, Response $response, array $args) {
    global $twig;
    $args['pagename'] = 'Articles';
    return $this->view->render($response, 'articles.twig');
})->setName('articles');

$app->get('/signup', function (Request $request, Response $response, array $args) {
    global $twig;
    $args['pagename'] = 'Signup';
    return $this->view->render($response, 'signup.twig');
})->setName('signup');

$app->get('/logout', function(Request $request, Response $response, array $args){
    session_unset();
    return $response->withRedirect('/', 301);
})->setName('logout');

$app->post('/login', function(Request $request,Response $response, $args) {
    $password = $request->getParam('password');
    $username = $request->getParam('username');
    $sql = 'SELECT * FROM users WHERE username = :username';
    $stmt= $this->db->prepare($sql);
    $stmt->bindValue('username', $username, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!password_verify($password, $result['passwd'])) {
        return $this->view->render($response, 'login.twig',$data);
    } else {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['permission'] = $result['permission_lvl'];
        return $response->withRedirect('/', 301);
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
        $stmt->bindValue('last_name', $lastname, PDO::PARAM_STR);
        $stmt->bindValue('first_name', $firstname, PDO::PARAM_STR);
        $stmt->bindValue('username', $username, PDO::PARAM_STR);
        $stmt->bindValue('passwd', $password, PDO::PARAM_STR);
        $stmt->bindValue('email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $response->withRedirect('/login', 301);
    }
    catch(Exception $e){
        var_dump($e->getMessage());
        return $this->view->render($response, 'signup.twig');
    }
})->setName('signup');

// ADMIN ROUTES

$app->get('/adm_dashboard', function (Request $request, Response $response, array $args) {
    global $twig;
    $args['pagename'] = 'Dashboard';
    return $response->getBody()->write($twig->render('adm_dashboard.twig', $args));
})->setName('adm_dashboard');

$app->get('/adm_articles', function (Request $request, Response $response, array $args) {
    global $twig;
    $args['pagename'] = 'Articles';
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
