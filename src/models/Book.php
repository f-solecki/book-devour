<?php

class Book
{
  public $id;
  public $title;
  public $authorId;
  public $genre;
  public $summary;
  public $cover_url;

  public function __construct($id, $title, $authorId, $genre, $summary, $cover_url)
  {
    $this->id = $id;
    $this->title = $title;
    $this->authorId = $authorId;
    $this->genre = $genre;
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

  public function getAuthorId()
  {
    return $this->authorId;
  }

  public function getCategoryId()
  {
    return $this->genre;
  }

  public function getSummary()
  {
    return $this->summary;
  }

  public function getCoverUrl()
  {
    return $this->cover_url;
  }

  public function getCoverUrlPath()
  {
    return 'public/assets/covers/' . $this->cover_url;
  }
  
}