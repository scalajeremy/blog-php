<?php
namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class MainController extends Controller{
    public function index(Request $request, Response $response, array $args) : Response {
        $displayArticles = $this->article->displayArticle();
        return $this->view->render($response, 'index.twig', array("articles"=>$displayArticles));
    }

    public function team(Request $request, Response $response, array $args) : Response {
        return $this->view->render($response, 'common/team.twig', []);
    }

    public function articles(Request $request, Response $response, array $args) : Response {
        $displayArticles = $this->article->displayArticle();
        return $this->view->render($response, 'common/articles.twig', array("articles"=>$displayArticles));
    }

    public function article(Request $request, Response $response, array $args) : Response {
        $article_id = $args['article_id'];
        $displayArticle = $this->article->getArticleById($article_id);
        return $this->view->render($response, 'common/article.twig', array("article"=>$displayArticle));
    }
}
