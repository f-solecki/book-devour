<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Book.php';

class BookRepository extends Repository
{
  public function getBooks()
  {
    $result = [];

    $query = $this->database->connect()->prepare('
      SELECT * FROM books
    ');
    $query->execute();
    $books = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($books as $book) {
      $result[] = new Book(
        $book['id'],
        $book['title'],
        $book['author_id'],
        $book['genre'],
        $book['summary'],
        $book['cover_url']
      );
    }

    return $result;
  }

  public function getBookById($id)
  {
    $query = $this->database->connect()->prepare('
      SELECT * FROM books WHERE id = :id
    ');
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();

    $book = $query->fetch(PDO::FETCH_ASSOC);

    if (!$book) {
      return null;
    }

    return new Book(
      $book['id'],
      $book['title'],
      $book['author_id'],
      $book['genre'],
      $book['summary'],
      $book['cover_url']
    );
  }


  public function removeBook($id)
  {
    $query = $this->database->connect()->prepare('
    DELETE FROM books WHERE id = :id
  ');
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
  }
}
