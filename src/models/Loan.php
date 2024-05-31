<?php

class Loan{
    public $id;
    public $book_id;
    public $user_id;
    public $loan_date;
    public $return_date;

    public function __construct($id, $book_id, $user_id, $loan_date, $return_date){
        $this->id = $id;
        $this->book_id = $book_id;
        $this->user_id = $user_id;
        $this->loan_date = $loan_date;
        $this->return_date = $return_date;
    }

    public function getId(){
        return $this->id;
    }

    public function getBookId(){
        return $this->book_id;
    }

    public function getUserId(){
        return $this->user_id;
    }

    public function getLoanDate(){
        return $this->loan_date;
    }

    public function getReturnDate(){
        return $this->return_date;
    }
}



