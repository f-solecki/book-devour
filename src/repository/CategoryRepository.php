<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Category.php';

class CategoryRepository extends Repository
{
  public function getCategories()
  {
    $result = [];

    $query = $this->database->connect()->prepare('
      SELECT * FROM genre
    ');
    $query->execute();
    $categories = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($categories as $category) {
      $result[] = new Category(
        $category['id'],
        $category['name'],
      );
    }

    return $result;
  }

  public function getCategoryById($id)
  {
    $query = $this->database->connect()->prepare('
      SELECT * FROM genre WHERE id = :id
    ');
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();

    $category = $query->fetch(PDO::FETCH_ASSOC);

    if (!$category) {
      return null;
    }

    return new Category(
      $category['id'],
      $category['name'],
    );
  }
}
