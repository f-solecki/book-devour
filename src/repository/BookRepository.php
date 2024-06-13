<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Book.php';

class BookRepository extends Repository
{
  public function getBooks()
  {
    $result = [];

    $query = $this->database->connect()->prepare('
      SELECT * FROM books ORDER BY id
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

  public function getRecommendedUserBooks($userId)
  {
    $query = $this->database->connect()->prepare('
      SELECT DISTINCT
        b2.id AS book_id,
        b2.title AS book_title,
        b2.summary AS book_summary,
        b2.cover_url AS book_cover_url,
        b2.author_id AS author_id,
        g.id AS genre_id
      FROM
        public.loans l
      JOIN
        public.books b1 ON l.book_id = b1.id
      JOIN
       public.genre g ON b1.genre = g.id
      JOIN
        public.books b2 ON b2.genre = g.id
      WHERE
        l.user_id = :userId
      ORDER BY
        g.id;
    ');
    $query->bindParam(':userId', $userId, PDO::PARAM_INT);
    $query->execute();
    $books = $query->fetchAll(PDO::FETCH_ASSOC);

    foreach ($books as $book) {
      $result[] = new Book(
        $book['book_id'],
        $book['book_title'],
        $book['author_id'],
        $book['genre_id'],
        $book['book_summary'],
        $book['book_cover_url']
      );
    }

    return $result;
  }


  public function deleteBook($id)
  {
    $query = $this->database->connect()->prepare('
    DELETE FROM books WHERE id = :id
  ');
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
  }
}
