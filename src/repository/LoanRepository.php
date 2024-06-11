<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/Loan.php';

class LoanRepository extends Repository{
    public function getLoansByUserId($id){
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

    public function loanBook($book_id, $user_id){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $query = $this->database->connect()->prepare('
                INSERT INTO loans (book_id, user_id, loan_date, return_date)
                VALUES (:book_id, :user_id, NOW(), DATE_ADD(NOW(), INTERVAL 1 MONTH))
            ');
            $query->bindParam(':book_id', $book_id, PDO::PARAM_INT);
            $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $query->execute();

            if ($query->rowCount() > 0) {
                return true; // Success
            } else {
                return false; // Failure
            }
        }
    }
}