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
      $sql = 'SELECT article_id, title, content, date_publication, author FROM articles';
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
}
