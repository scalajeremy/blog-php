<?php
namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class MainController extends Controller{
  // index display aerticles
    public function index(Request $request, Response $response, array $args) : Response {
        $displayArticles = $this->article->displayArticle();
        return $this->view->render($response, 'index.twig', array("articles"=>$displayArticles));
    }

    public function team(Request $request, Response $response, array $args) : Response {
        return $this->view->render($response, 'common/team.twig', []);
    }
    // Display Articles by category
    public function articles(Request $request, Response $response, array $args) : Response {
      $displayArticle = $this->article->displayArticle();
      $displayCategories = $this->categorie->displayCategorie();
      return $this->view->render($response, 'common/articles.twig', array("articles"=>$displayArticle, "categories"=>$displayCategories));
    }

    public function article(Request $request, Response $response, array $args) : Response {
        $article_id = $args['article_id'];
        $displayArticle = $this->article->getArticleById($article_id);
        return $this->view->render($response, 'common/article.twig', array("article"=>$displayArticle));
    }

    public function articlesByCat(Request $request, Response $response, array $args) : Response {
      $category_id = $args['category_id'];
      $displayCategories = $this->categorie->displayCategorie();
      $displayArticle = $this->article->displayArticleByCat($category_id);
      return $this->view->render($response, 'common/articles.twig', array("articles"=>$displayArticle, "categories"=>$displayCategories));
    }
}
