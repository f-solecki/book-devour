<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Author.php';

class AuthorRepository extends Repository
{

  public function getAuthors()
  {
    $result = [];

    $query = $this->database->connect()->prepare('
      SELECT * FROM authors
    ');
    $query->execute();
    $authors = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($authors as $author) {
      $result[] = new Author(
        $author['id'],
        $author['first_name'],
        $author['last_name'],
        $author['biography'],
        $author['books']
      );
    }

    return $result;
  }

  public function getAuthorById($id)
  {
    $query = $this->database->connect()->prepare('
      SELECT * FROM authors WHERE id = :id
    ');
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();

    $author = $query->fetch(PDO::FETCH_ASSOC);

    if (!$author) {
      return null;
    }

    return new Author(
      $author['id'],
      $author['first_name'],
      $author['last_name'],
      $author['biography'],
      $author['books']
    );
  }
  
}