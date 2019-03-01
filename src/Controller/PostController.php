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

class PostController extends Controller
{


    public function listing(Request $request, Response $response, array $args) : Response
    {

        // no database implemented
        $posts = [
            [
                'id' => 1,
                'slug' => 'my-post-1',
                'title' => 'My post title 1',
                'body' => 'Content'
            ],[
                'id' => 1,
                'slug' => 'my-post-1',
                'title' => 'My post title 1',
                'body' => 'Content'
            ]
        ];

        $this->logger->info('This is an info log');
        $this->logger->error('This is an error log');
        var_dump($posts);

        return $response->withStatus(200);
    }

    public function index(Request $request, Response $response, array $args) : Response
    {

        $name = 'johnny';
        return $this->view->render($reponse, 'post/index.twig', [
            'name' => $name,
            'posts' => $this->post->getAll()
        ]);
    }

    public function show(Request $request, Response $response, array $args) : Response
    {

    }
}