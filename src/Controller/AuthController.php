<?php
/**
 * Created by PhpStorm.
 * User: jonat
 * Date: 19-02-19
 * Time: 21:16
 */

namespace App\Controller;


use Slim\Http\Request;
use Slim\Http\Response;

class AuthController extends Controller
{

    public function signin(Request $request, Response $response, array $args) {

        // render form

        return $this->view->render($response, 'auth/signin.twig');
    }

    public function signinAction(Request $request, Response $response, array $args) : Response{
       
        
        $password = $request->getParam('password');
        $username = $request->getParam('username');

        if( $this->user->authenticate($username, $password)){

            return $response->withRedirect($this->router->pathFor('app.index'), 301);

        }else{

            // flash
            $_SESSION['flash']['danger'] = 'Tu t\'es viandé';
            return $response->withRedirect($this->router->pathFor('app.index'), 301);

        }

        return $response;
    }
}