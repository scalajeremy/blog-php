<?php
use App\Controller\MainController;
use App\Controller\PostController;
use App\Middleware\AuthMiddleware;
use Slim\Http\Request;
use Slim\Http\Response;

// this is a route directly implemented
$app->get('/', MainController::class. ':index')->setName('app.index');

// defining a route group, in that case all uri will have /post then the path added in the group
$app->group('/post', function(){
    $this->get('', PostController::class.':index');
    // this calls the controller
    $this->get('/{slug: [a-zA-Z0-9]+}', PostController::class.':show');
});

$app->group('/admin', function(){
    $this->get('/admin', PostController::class.':index');
    // this calls the controller
    $this->get('/{slug: [a-zA-Z0-9]+}', PostController::class.':show');
})->add(new AuthMiddleware($container, 2));


$app->group('/author', function(){
    $this->get('/{slug: [a-zA-Z0-9]+}', PostController::class.':show');
})->add(new AuthMiddleware($container, 1));

/*

$app->get('/home', function (Request $request, Response $response){
    return $response->withRedirect('/', 301);
})->setName('app.home');
$app->get('/login', function (Request $request, Response $response, array $args) {
    return $this->view->render($response, 'auth/login.twig');
})->setName('app.login');
$app->get('/team', function (Request $request, Response $response, array $args) {
    return $this->view->render($response, 'common/team.twig');
})->setName('app.team');
$app->get('/articles', function (Request $request, Response $response, array $args) {
    return $this->view->render($response, 'common/articles.twig');
})->setName('app.articles');
$app->get('/signup', function (Request $request, Response $response, array $args) {
    return $this->view->render($response, 'auth/signup.twig');
})->setName('app.signup');
$app->get('/logout', function(Request $request, Response $response, array $args){
    session_unset();
    return $response->withRedirect('/', 301);
})->setName('app.logout');
$/
*/