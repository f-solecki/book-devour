<?php

class LoanedBook
{
  public $id;
  public $title;
  public $authorFirstName;
  public $authorLastName;
  public $genreName;
  public $returnDate;
  public $summary;
  public $cover_url;

  public function __construct($id, $title, $authorFirstName, $authorLastName, $genreName, $returnDate, $summary, $cover_url)
  {
    $this->id = $id;
    $this->title = $title;
    $this->authorFirstName = $authorFirstName;
    $this->authorLastName = $authorLastName;
    $this->genreName = $genreName;
    $this->returnDate = $returnDate;
    $this->summary = $summary;
    $this->cover_url = $cover_url;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getTitle()
  {
    return $this->title;
  }


  public function getGenreName()
  {
    return $this->genreName;
  }

  public function getReturnDate()
  {
    return $this->returnDate;
  }

  public function getSummary()
  {
    return $this->summary;
  }

  public function getCoverUrl()
  {
    return $this->cover_url;
  }

  public function getAuthorName()
  {
    return $this->authorFirstName . ' ' . $this->authorLastName;
  }

  public function getCoverUrlPath()
  {
    return 'public/assets/covers/' . $this->cover_url;
  }
  
}