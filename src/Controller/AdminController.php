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
    return $this->view->render($response, 'admin/adm_articles.twig', ['articles'=>$displayArticles]);
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
  ////////////
  public function usersAction(Request $request, Response $response, array $args) : Response{
      $firstname = $request->getParam('firstname');
      $lastname = $request->getParam('lastname');
      $email = $request->getParam('email');
      $username = $request->getParam('username');
      $password = $request->getParam('password');

      if($this->user->addUser($firstname, $lastname, $email, $username, $password)){
          return $response->withRedirect($this->router->pathFor('app.login'),301);
      }else{
          $_SESSION['flash']['danger'] = 'Problem while signing up.';
          return $response->withRedirect($this->router->pathFor('app.signup'),301);
      }
      return $response;
  }
////////////
}
