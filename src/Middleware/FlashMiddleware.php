<?php
namespace App\Middleware;

use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class FlashMiddleware
{

    /** @var ContainerInterface $container */
    private $container;

    /**
     * AppLocalMiddleware constructor.
     * @param $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * add a flash global variable to the Twig instance to display the flash messages
     * @param Request $request
     * @param Response $response
     * @param $next
     * @return mixed
     */
    public function __invoke(Request $request, Response $response, $next)
    {

        if(!empty($_SESSION['flash'])){
            $this->container->view->getEnvironment()->addGlobal('flash', $_SESSION['flash']);
            unset($_SESSION['flash']);
        }

        return  $next($request, $response);

    }
}
