<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Loan.php';
require_once __DIR__ . '/../models/LoanedBook.php';

class LoanRepository extends Repository
{
    public function getLoansByUserId($id)
    {
        $result = [];

        $query = $this->database->connect()->prepare('
        SELECT DISTINCT
        b.id AS book_id,
        b.title AS book_title,
        b.summary AS book_summary,
        b.cover_url AS book_cover_url,
        b.author_id AS author_id,
        b.genre AS genre_id,
        l.return_date AS return_date
      FROM
        public.loans l
      JOIN
        public.books b ON l.book_id = b.id
            WHERE user_id = :id 
            ORDER BY return_date ASC');
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        $books = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($books as $book) {
            $result[] = new LoanedBook(
                $book['book_id'],
                $book['book_title'],
                $book['author_id'],
                $book['genre_id'],
                $book['book_summary'],
                $book['book_cover_url'],
                $book['return_date']
            );
        }

        return $result;
    }

    public function getLoanedBooks()
    {
        $result = [];

        $query = $this->database->connect()->prepare('
            SELECT * FROM loans
        ');
        $query->execute();
        $loans = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($loans as $loan) {
            $result[] = new Loan(
                $loan['id'],
                $loan['book_id'],
                $loan['user_id'],
                $loan['loan_date'],
                $loan['return_date']
            );
        }

        return $result;
    }

    public function loanBook($loan)
    {
        $query = $this->database->connect()->prepare('
            INSERT INTO loans (book_id, user_id, loan_date, return_date)
            VALUES (?, ?, ?, ?);
        ');

        $query->execute([
            $loan->getBookId(),
            $loan->getUserId(),
            $loan->getLoanDate(),
            $loan->getReturnDate()
        ]);
    }

    public function isBookLoaned($bookId, $userId)
    {
        $query = $this->database->connect()->prepare('
            SELECT * FROM loans WHERE book_id = :book_id AND user_id = :user_id
        ');
        $query->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $query->execute();

        return $query->rowCount() > 0;
    }

    public function returnBook($bookId, $userId)
    {
        $query = $this->database->connect()->prepare('
            DELETE FROM loans WHERE book_id = :book_id AND user_id = :user_id
        ');
        $query->bindParam(':book_id', $bookId, PDO::PARAM_INT);
        $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $query->execute();
    }
}
