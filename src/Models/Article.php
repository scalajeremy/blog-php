<?php
namespace App\Models;

use Slim\Container;

class Article {
    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function addArticle() : bool{
        return false;
    }

    public function displayArticle(){
      $sql = 'SELECT ar.article_id, ar.title, ar.content, ar.date_publication, ar.author, u.username
      FROM articles ar, users u
      WHERE ar.author = u.user_id';
      $stmt= $this->container->db->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll();

      return $result;
    }

    public function editArticle() : bool{
        return false;
    }

    public function deleteArticle() : bool{
        return false;
    }

    public function displayNumArticles(){
      $sql = 'SELECT COUNT(*) FROM articles';
      $stmt= $this->container->db->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);

      return $result;
    }

    public function displayNumComments(){
      $sql = 'SELECT COUNT(*) FROM comments';
      $stmt= $this->container->db->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);

      return $result;
    }

}
