<?php

class LoanedBook extends Book
{
  public $returnDate;

  public function __construct($id, $title, $authorId, $genre, $summary, $cover_url, $returnDate)
  {
    parent::__construct($id, $title, $authorId, $genre, $summary, $cover_url);
    $this->returnDate = $returnDate;
  }

  public function getReturnDate()
  {
    return $this->returnDate;
  }
}
