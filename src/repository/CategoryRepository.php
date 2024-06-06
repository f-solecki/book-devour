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
}
