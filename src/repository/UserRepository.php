<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/User.php';

class UserRepository extends Repository
{
  public function getUser($email, $id = null)
  {
    $query = $this->database->connect()->prepare('
      SELECT * FROM users WHERE email = :email OR id = :id
    ');
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();

    $user = $query->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
      return null;
    }

    return new User($user['id'], $user['first_name'], $user['last_name'], $user['email'], $user['password'], $user['created_at'], $user['is_admin']);
  }

  public function isUserAdmin($id)
  {
    $query = $this->database->connect()->prepare('
    SELECT is_admin FROM users WHERE id = :id
  ');
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->execute();

    $user = $query->fetch(PDO::FETCH_ASSOC);

    return $user["is_admin"];
  }

  public function createUser($data)
  {
    $query = $this->database->connect()->prepare('
      INSERT INTO users (first_name, last_name, email, password)
      VALUES (?, ?, ?, ?)
    ');

    $query->execute([
      $data['firstName'],
      $data['lastName'],
      $data['email'],
      $data['password']
    ]);

    return;
  }

  public function removeUser($id)
  {
    $this->deleteUsersLoans($id);
    $this->deleteUser($id);
  }

  private function deleteUsersLoans($id)
  {
    $query = $this->database->connect()->prepare('
      DELETE FROM loans WHERE user_id = :id
    ');

    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
  }

  private function deleteUser($id)
  {
    $query = $this->database->connect()->prepare('
      DELETE FROM users WHERE id = :id
    ');

    $query->bindParam(':id', $id, PDO::PARAM_INT);
    $query->execute();
  }
}
