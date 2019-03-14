<?php
namespace App\Middleware;

use Slim\Http\Request;
use Slim\Http\Response;

class AdminPermissionMiddleware {

    private $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function __invoke(Request $request, Response $response, $next) {
        if (!isset($_SESSION['auth']) || empty($_SESSION['auth'])) {
            return $response->withRedirect($this->container->router->pathFor('app.index'));
        }elseif($_SESSION['auth']['permission'] < 2){
            return $response->withRedirect($this->container->router->pathFor('app.index'));
        }
        $response = $next($request, $response);
        return $response;
    }
}