<?php

use App\Controller\MainController;
use App\Controller\AuthController;
//use App\Controller\SignUpController;
use Slim\Http\Request;
use Slim\Http\Response;

// this is a route directly implemented
$app->get('/', MainController::class.':index')->setName('app.index');

$app->get('/team', MainController::class.':team')->setName('app.team');

$app->get('/articles', MainController::class.':articles')->setName('app.articles');

$app->get('/login', AuthController::class.':login')->setName('app.login');

$app->post('/login', AuthController::class.':loginAction')->setName('app.login');

//$app->get('/signup', SignUpController::class.'signup')->setName('app.signup');
//$app->post('/signup', SignUpController::class.'signupAction')->setName('app.signup');




/*
$app->get('/logout', function(Request $request, Response $response, array $args){
    session_unset();
    return $response->withRedirect('/', 301);
})->setName('app.logout');

// defining a route group, in that case all uri will have /post then the path added in the group

$app->group('/post', function(){
    $this->get('', PostController::class.':index');
    // this calls the controller
    $this->get('/{slug: [a-zA-Z0-9]+}', PostController::class.':show');

});
*/