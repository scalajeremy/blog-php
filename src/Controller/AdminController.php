<?php
namespace App\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class AdminController extends Controller{
  public function dashboard(Request $request, Response $response, array $args) {
    $displayNumArticles = $this->article->displayNumArticles();
    $displayNumUsers = $this->user->displayNumUsers();
    $displayNumComments = $this->article->displayNumComments();
    $displayNumCat = $this->categorie->displayNumCat();
    return $this->view->render($response, 'admin/adm_dashboard.twig', array("numArticles"=>$displayNumArticles, "numCat"=>$displayNumCat, "numUsers"=>$displayNumUsers, "numComments"=>$displayNumComments));
  }
  public function addArticles(Request $request, Response $response, array $args) {
    $displayCategorie = $this->categorie->displayCategorie();
    return $this->view->render($response, 'admin/adm_add_articles.twig', array("categories"=>$displayCategorie));
  }
  public function articles(Request $request, Response $response, array $args) {
    $displayArticles = $this->article->displayArticle();
    return $this->view->render($response, 'admin/adm_articles.twig', array("articles"=>$displayArticles));
  }
  public function articlesAction(Request $request, Response $response, array $args) : Response{

    $addTitle = $request->getParam('addArticleTitle');
    // $addCategory = $request->getParam('addArticleCategory');
    $addContent = $editor_data = $_POST[ 'content' ];
    if($this->article->addArticle($addTitle, $addContent)){
      return $response->withRedirect($this->router->pathFor('adm.articles'),301);
    }else{
      return $response->withRedirect($this->router->pathFor('adm.articles'),301);
    }
  }

  public function categories(Request $request, Response $response, array $args) {
    $displayCategorie = $this->categorie->displayCategorie();
    return $this->view->render($response, 'admin/adm_cat.twig', array("categories"=>$displayCategorie));
  }
  public function categoriesAction(Request $request, Response $response, array $args) : Response{
    $addCategory = $request->getParam('addCategory');
    if($this->categorie->addCategorie($addCategory)){
      return $response->withRedirect($this->router->pathFor('adm_cat'),301);
    }else{
      return $response->withRedirect($this->router->pathFor('adm_cat'),301);
    }
  }
  public function media(Request $request, Response $response, array $args) {
    return $this->view->render($response, 'admin/adm_media.twig');
  }
  public function users(Request $request, Response $response, array $args) {
    $displayUsers = $this->user->displayUsers();
    return $this->view->render($response, 'admin/adm_users.twig', array("users"=>$displayUsers));
  }
  ////////////
  public function usersAction(Request $request, Response $response, array $args) : Response{
      $firstname = $request->getParam('addFirstname');
      $lastname = $request->getParam('addLastname');
      $email = $request->getParam('addEmail');
      $username = $request->getParam('addUsername');
      $password = $request->getParam('addPasswd');

      if($this->user->addUser($firstname, $lastname, $email, $username, $password)){
          return $response->withRedirect($this->router->pathFor('adm_users'),301);
      }else{
          $_SESSION['flash']['danger'] = 'Problem while signing up.';
          return $response->withRedirect($this->router->pathFor('adm_users'),301);
      }
      return $response;
  }
////////////

public function userDelete(Request $request, Response $response, array $args) : Response{
    $username = $args['username'];
    if($this->user->deleteUser($username)){
        return $response->withRedirect($this->router->pathFor('adm_users'),301);
    }else{
        $_SESSION['flash']['danger'] = 'Problem while signing up.';
        return $response->withRedirect($this->router->pathFor('adm_users'),301);
    }
    return $response;
}
////Jam : 13/03/2019 : boutton edit
public function fillUserEdit(Request $request, Response $response, array $args) : Response{
    $id = $args['id'];
    $fillUserEditInfo = $this->user->getUserInfoById($id);  // testing it out
    $displayUsers = $this->user->displayUsers();
    // if($this->user->editUser($id)){
        // return $response->withRedirect($this->router->pathFor('adm_users'),301); on va essayer avec un render pour envoyer les données en array à la page
    return $this->view->render($response, 'admin/adm_users_edit.twig', array("fillUserEditInfo"=>$fillUserEditInfo, "users"=>$displayUsers));
}

public function userEdit(Request $request, Response $response, array $args) : Response{
    $firstname = $request->getParam('addFirstname');
    $lastname = $request->getParam('addLastname');
    $email = $request->getParam('addEmail');
    $username = $request->getParam('addUsername');
    $password = $request->getParam('addPasswd');
    $permission = $request->getParam('addPermission');
    $id = $args['id'];
    if($this->user->editUser($id, $firstname, $lastname, $email, $username, $password, $permission)){
        return $response->withRedirect($this->router->pathFor('adm_users'),301);
    }else{
        $_SESSION['flash']['danger'] = 'Problem while signing up.';
        return $response->withRedirect($this->router->pathFor('adm_users'),301);
    }
    return $response;
}

////// Jam : 14/09/2019 : je fais edit et delete cat.

public function catDelete(Request $request, Response $response, array $args) : Response{
    $category_id = $args['category_id'];
    if($this->categorie->deleteCategorie($category_id)){
        return $response->withRedirect($this->router->pathFor('adm_cat'),301);
    }else{
        $_SESSION['flash']['danger'] = 'Problem while signing up.';
        return $response->withRedirect($this->router->pathFor('adm_cat'),301);
    }
    return $response;
}

public function fillCatEdit(Request $request, Response $response, array $args) : Response{
    $category_id = $args['category_id'];
    $fillCatEditInfo = $this->categorie->getCatInfoById($category_id);  // testing it out
    $displayCat = $this->categorie->displayCategorie();
    // if($this->user->editUser($id)){
        // return $response->withRedirect($this->router->pathFor('adm_users'),301); on va essayer avec un render pour envoyer les données en array à la page
    return $this->view->render($response, 'admin/adm_cat_edit.twig', array("fillCatEditInfo"=>$fillCatEditInfo, "categories"=>$displayCat));
}

// 11h24 new
// public function catEdit(Request $request, Response $response, array $args) : Response{
//     $firstname = $request->getParam('addFirstname');
//     $lastname = $request->getParam('addLastname');
//     $email = $request->getParam('addEmail');
//     $username = $request->getParam('addUsername');
//     $password = $request->getParam('addPasswd');
//     $permission = $request->getParam('addPermission');
//     if($this->user->editUser($id, $firstname, $lastname, $email, $username, $password, $permission)){
//         return $response->withRedirect($this->router->pathFor('adm_users'),301);
//     }else{
//         $_SESSION['flash']['danger'] = 'Problem while signing up.';
//         return $response->withRedirect($this->router->pathFor('adm_users'),301);
//     }
//     return $response;
// }
//
//

}
