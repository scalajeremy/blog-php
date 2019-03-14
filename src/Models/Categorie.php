<?php
namespace App\Models;

use Slim\Container;

class Categorie {
    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }
    // Request for add a category
    public function addCategorie($addCategory) : bool{
        $addCategory = htmlspecialchars($addCategory);
        try{
          $sql = "INSERT INTO categories (cat_name)
          VALUES (:cat_name)";
          $stmt = $this->container->db->prepare($sql);
          $stmt->bindValue('cat_name', $addCategory, \PDO::PARAM_STR);
          $req = $stmt->execute();
            return true;
        }
        catch(Exception $e){
            return false;
        }
    }
    // Request for number of categories in db
    public function displayNumCat(){
      $sql = 'SELECT COUNT(*) FROM categories';
      $stmt= $this->container->db->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetch(\PDO::FETCH_ASSOC);

      return $result;
    }
    // Request for edit a category
    public function editCategorie() : bool{
        return false;
    }
    // Request for deleting a category
    public function deleteCategorie($category_id) : bool{
      $category_id = htmlspecialchars($category_id);

      try{
          $sql = "DELETE FROM list_of_categories WHERE category= :category_id";
          $stmt= $this->container->db->prepare($sql);
          $stmt->bindValue('category_id', $category_id, \PDO::PARAM_INT);
          $stmt->execute();

          $sql = "DELETE FROM categories WHERE category_id= :category_id";
          $stmt= $this->container->db->prepare($sql);
          $stmt->bindValue('category_id', $category_id, \PDO::PARAM_INT);
          $stmt->execute();

          return true;
      }
      catch(Exception $e){
          return false;
      }
  }

    // Request for displaying categories
    public function displayCategorie(){
      $sql = 'SELECT cat_name, category_id
      FROM categories
      ORDER BY category_id';
      $stmt= $this->container->db->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll();

      return $result;
    }
}
