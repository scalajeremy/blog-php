<?php
namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class MainMiddleware{
    private $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response, $next){
        return $next($request, $response);
    }
}