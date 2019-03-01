<?php

namespace App\Controller;


use Slim\Http\Request;
use Slim\Http\Response;

class MainController extends Controller{
    public function index(Request $request, Response $response, $args) : Response{
        return $this->view->render($response, 'index.twig', [
            'posts' => $this->post->getAll()
            ]);
        // return $this->render($response, 'index.twig', $args);
    }
/*
    public function login(Request $request, Response $response, array $args) : Response{
        return $this->view->render($reponse, 'auth/login.twig', $args);
    }

    public function team(Request $request, Response $response, array $args) : Response{
        return $this->view->render($reponse, 'common/team.twig', $args);
    }

    public function article(Request $request, Response $response, array $args) : Response{
        return $this->view->render($reponse, 'common/articles.twig', $args);
    }

    public function signup(Request $request, Response $response, array $args) : Response{
        return $this->view->render($reponse, 'auth/signup.twig', $args);
    }*/
}