<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Loan.php';

class LoanRepository extends Repository
{
    public function getLoansByUserId($id)
    {
        $result = [];

        $query = $this->database->connect()->prepare('
            SELECT * FROM loans WHERE user_id = :id ORDER BY return_date ASC
        ');
        $query->bindParam(':id', $id, PDO::PARAM_INT);
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
