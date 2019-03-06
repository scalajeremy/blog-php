<?php
namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class SignUpController extends Controller{

    public function signup(Request $request, Response $response, array $args) {
        return $this->view->render($response, 'auth/signup.twig');
    }

    public function signupAction(Request $request, Response $response, array $args) : Response{
        $firstname = $request->getParam('firstname');
        $lastname = $request->getParam('lastname');
        $email = $request->getParam('email');
        $username = $request->getParam('username');
        $password = $resquest->getParam('password');
        
        if($this->user->addUser($firstname, $lastname, $email, $username, $password)){
            return $response->withRedirect($this->router->pathFor('app.login'),301);
        }else{
            $_SESSION['flash']['danger'] = 'Problem while signing up.';
            return $response->withRedirect($this->router->pathFor('app.signup'),301);
        }
        return $response;
    }    
}