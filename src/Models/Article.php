<?php
namespace App\Models;

use Slim\Container;

class Article {
    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function addArticle($addTitle, $addContent, $categories) : bool{
        $addTitle = htmlspecialchars($addTitle);
        $addContent = htmlspecialchars_decode($addContent, ENT_HTML5);
        try{
          $sql = "INSERT INTO articles (title, content, date_publication, author)
          VALUES (:title, :content, NOW(), :author)
          RETURNING article_id";
          $stmt = $this->container->db->prepare($sql);
          $req = $stmt->execute([
            'title' => $addTitle,
            'content' => $addContent,
            'author' => $_SESSION["auth"]["user_id"]
          ]);
          $article = $stmt->fetch(\PDO::FETCH_ASSOC);
          var_dump($article);
          if(!empty($categories)){
            foreach($categories as $selected){
              $sql = "INSERT INTO list_of_categories(article, category)
              VALUES (:article, :category)";
              $stmt = $this->container->db->prepare($sql);
              $req = $stmt->execute([
                'article' => $article['article_id'],
                'category' => $selected
              ]);
            }
            return true;
          }else{
            $sql = "INSERT INTO list_of_categories(article, category)
            VALUES (:article, 0)";
            $stmt = $this->container->db->prepare($sql);
            $req = $stmt->execute([
              'article' => $article['article_id']
            ]);
            return true;
          }
        }catch(Exception $e){
            return false;
        }
    }

    public function displayArticle(){
      $sql = 'SELECT a.article_id, a.title, a.date_publication, a.content, u.username
      FROM users u, articles a
      WHERE a.author = u.user_id AND a.article_id IN
      (SELECT DISTINCT lc.article
      FROM list_of_categories lc)
      ORDER BY a.date_publication DESC';
      $stmt= $this->container->db->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll();
      $i = 0;
      foreach($result as $article){
          $sql = 'SELECT c.cat_name, c.category_id
          FROM categories c, list_of_categories lc
          WHERE c.category_id = lc.category AND lc.article ='.$article['article_id'];
          $stmt = $stmtm = $this->container->db->prepare($sql);
          $stmt->execute();
          $categories = $stmt->fetchAll();
          $result[$i]['categories'] = $categories;
          $i++;
      }
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
