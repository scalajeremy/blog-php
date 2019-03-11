<?php
namespace App\Models;

use Slim\Container;

class Categorie {
    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function addCategorie() : bool{
        return false;
    }

    public function editCategorie() : bool{
        return false;
    }

    public function deleteCategorie() : bool{
        return false;
    }

    public function displayCategorie(){
      $sql = 'SELECT cat_name
      FROM categories';
      $stmt= $this->container->db->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll();

      return $result;
    }
}