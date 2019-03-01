<?php
namespace App\Middleware;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class FlashMiddleware{
    /** @var ContainerInterface $container */
    private $container;
    private $level;

    /**
     * AppLocalMiddleware constructor.
     * @param $container
     */
    public function __construct($container, $level){
        $this->container = $container;
        $this->level = $level;
    }

    /**
     * add a flash global variable to the Twig instance to display the flash messages
     * @param Request $request
     * @param Response $response
     * @param $next
     * @return mixed
     */
    public function __invoke(Request $request, Response $response, $next){
        if(!empty($_SESSION['auth'])){
            // check User
            if( $this->container->user->check() ){
                if($_SESSION['auth']['permission']  >= $level){
                    return $next($request, $response);
                }
            // response->withHeader('authencation-token' => tokenSESSION)
            // flash // logger 
            }
        }
        return $response->withRedirect($this->router->pathFor('app.index'));
    }
}
