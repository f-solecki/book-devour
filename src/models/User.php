<?php

class User
{
  public $id;
  public $firstName;
  public $lastName;
  public $email;
  public $password;
  public $createdAt;
  public $isAdmin;

  public function __construct($id, $firstName, $lastName, $email, $password, $createdAt, $isAdmin)
  {
    $this->id = $id;
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->email = $email;
    $this->password = $password;
    $this->createdAt = $createdAt;
    $this->isAdmin = $isAdmin;
  }

  public function getId()
  {
    return $this->id;
  }

  public function getFirstName()
  {
    return $this->firstName;
  }

  public function getLastName()
  {
    return $this->lastName;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function getCreatedAt()
  {
    return $this->createdAt;
  }

  public function isAdmin()
  {
    return $this->isAdmin;
  }
}