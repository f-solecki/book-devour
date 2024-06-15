<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class UserController extends AppController
{
  private $userRepository;

  public function __construct()
  {
    parent::__construct();

    $this->userRepository = new UserRepository();
  }

  public function profile()
  {
    $this->loginRequired();

    $userId = $this->getSession()->getUserId();
    $user = $this->userRepository->getUser('', $userId);
    $isAdmin = $user->isAdmin();

    $this->render('profile', ['user' => $user, 'isAdmin' => $isAdmin]);
  }

  public function remove_account()
  {
    $this->loginRequired();

    $userId = $this->getSession()->getUserId();
    $this->userRepository->removeUser($userId);

    $this->getSession()->destroy();
    redirect('/login');  }
}
