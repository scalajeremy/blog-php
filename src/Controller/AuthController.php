<?php
namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class AuthController extends Controller{

    public function login(Request $request, Response $response, array $args) {
        return $this->view->render($response, 'auth/login.twig');
    }

    public function loginAction(Request $request, Response $response, array $args) : Response{
        $password = $request->getParam('password');
        $username = $request->getParam('username');

        if( $this->user->authenticate($username, $password)){
            return $response->withRedirect($this->router->pathFor('app.index'), 301);
        }else{
            // flash
            $_SESSION['flash']['danger'] = 'Tu t\'es viandé';
            return $response->withRedirect($this->router->pathFor('app.login'), 301);
        }
    }

    public function logoutAction(Request $request, Response $response, array $args) : Response{
        session_unset();
        //$_SESSION['auth'] = ['login' => false ];
        return $response->withRedirect($this->router->pathFor('app.index'), 301);
    }
}