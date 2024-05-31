<?php

class Author
{
  public $id;
  public $first_name;
  public $last_name;
  public $biography;
  public $books;

  public function __construct($id, $first_name, $last_name, $biography, $books)
  {
    $this->id = $id;
    $this->first_name = $first_name;
    $this->last_name = $last_name;
    $this->biography = $biography;
    $this->books = $books;
  }
  
  public function getId()
  {
    return $this->id;
  }

  public function getFirstName()
  {
    return $this->first_name;
  }

  public function getLastName()
  {
    return $this->last_name;
  }

  public function getBiography()
  {
    return $this->biography;
  }

  public function getBooks()
  {
    return $this->books;
  }

  public function getFullName()
  {
    return $this->first_name . ' ' . $this->last_name;
  }

  public function getBooksCount()
  {
    return count($this->books);
  }


  

}