<?php
namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class AdminController extends Controller{
  public function dashboard(Request $request, Response $response, array $args) {
    return $this->view->render($response, 'admin/adm_dashboard.twig');
  }
  public function addArticles(Request $request, Response $response, array $args) {
    return $this->view->render($response, 'admin/adm_add_articles.twig');
  }
  public function articles(Request $request, Response $response, array $args) {
    $displayArticles = $this->article->displayArticle();
    return $this->view->render($response, 'admin/adm_articles.twig', array("articles"=>$displayArticles));
  }
  public function categories(Request $request, Response $response, array $args) {
    return $this->view->render($response, 'admin/adm_cat.twig');
  }
  public function media(Request $request, Response $response, array $args) {
    return $this->view->render($response, 'admin/adm_media.twig');
  }
  public function users(Request $request, Response $response, array $args) {
    return $this->view->render($response, 'admin/adm_users.twig');
  }
}
