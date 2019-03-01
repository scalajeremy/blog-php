<?php

use App\Controller\PostController;
use App\Middleware\AuthMiddleware;
use Slim\Http\Request;
use Slim\Http\Response;

// this is a route directly implemented
$app->get('/', function(Request $request, Response $response, array $args){
    return $response->withStatus(200)->getBody()->write('Hello world!');
})->setName('app.index');

// defining a route group, in that case all uri will have /post then the path added in the group

$app->group('/post', function(){
    $this->get('', PostController::class.':index');
    // this calls the controller
    $this->get('/{slug: [a-zA-Z0-9]+}', PostController::class.':show');
});

$app->group('/admin', function(){
    $this->get('', PostController::class.':index');
    // this calls the controller
    $this->get('/{slug: [a-zA-Z0-9]+}', PostController::class.':show');
})->add(new AuthMiddleware($container, 2));

$app->group('/author', function(){
    $this->get('/{slug: [a-zA-Z0-9]+}', PostController::class.':show');
})->add(new AuthMiddleware($container, 1));
