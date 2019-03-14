<?php
namespace App\Models;

use Slim\Container;

class Article {
    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function addArticle($addTitle, $addContent) : bool{
        $addTitle = htmlspecialchars($addTitle);
        $addContent = htmlspecialchars_decode($addContent, ENT_HTML5);
        // $addCategory = htmlspecialchars($addCategory);
        // $addAuthor = htmlspecialchars($addAuthor);
        try{
          $sql = "INSERT INTO articles (title, content, date_publication, author)
          VALUES (:title, :content, NOW(), :author)";
          $stmt = $this->container->db->prepare($sql);
          $req = $stmt->execute([
            'title' => $addTitle,
            'content' => $addContent,
            'author' => $_SESSION["auth"]["user_id"]
          ]);
            return true;
        }
        catch(Exception $e){
            return false;
        }
    }

    public function displayArticle(){
      $sql = 'SELECT a.article_id, a.title, a.date_publication, a.content, u.username
      FROM users u, articles a
      WHERE a.author = u.user_id AND a.article_id IN
      (SELECT DISTINCT lc.article
      FROM list_of_categories lc)';
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

    // Jam  : 15h30 14/03/2019 ci-dessous

//////////////////
public function deleteArticle($article_id) : bool{
  $article_id = htmlspecialchars($article_id);

  try{
      $sql = "DELETE FROM comments WHERE article= :article_id";
      $stmt= $this->container->db->prepare($sql);
      $stmt->bindValue('article_id', $article_id, \PDO::PARAM_INT);
      $stmt->execute();

      $sql = "DELETE FROM list_of_categories WHERE article= :article_id";
      $stmt= $this->container->db->prepare($sql);
      $stmt->bindValue('article_id', $article_id, \PDO::PARAM_INT);
      $stmt->execute();

      $sql = "DELETE FROM articles WHERE article_id= :article_id";
      $stmt= $this->container->db->prepare($sql);
      $stmt->bindValue('article_id', $article_id, \PDO::PARAM_INT);
      $stmt->execute();


      return true;
  }
  catch(Exception $e){
      return false;
  }
}
//////////////////////////////////////////////
////////////////// Jam : same day, 16:05, edit article
// 16H17 Il me faut les cat de l'art, donc des éléments de 2 tables avec des conditions WHERE sur 2 tables, jsp comment faire donc j'vais faire 2 requetes sql séparées et voir si ça marche pour pas perdre de temps (Bicky occupé)

public function getArtInfoById($article_id){
    $article_id = htmlspecialchars($article_id);
    $sql = "SELECT title, content FROM articles WHERE article_id = :article_id";
    $stmt= $this->container->db->prepare($sql);
    $stmt->bindValue('article_id', $article_id, \PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll();

    $sql2 = "SELECT category FROM list_of_categories WHERE article = :article_id";
    $stmt= $this->container->db->prepare($sql2);
    $stmt->bindValue('article_id', $article_id, \PDO::PARAM_INT);
    $stmt->execute();
    $result2 = $stmt->fetchAll();
    $result[0]['categories'] = $result2;

    return $result;
}




}
