<?php

require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../SessionManager.php';
require_once __DIR__ . '/../utils/utils.php';


class AppController
{
  private $request;
  private $sessionService;
  private $user;

  public function __construct()
  {
    $this->request = $_SERVER['REQUEST_METHOD'];
    $this->sessionService = null;
  }

  protected function isGet(): bool
  {
    return $this->request === 'GET';
  }

  protected function isPost(): bool
  {
    return $this->request === 'POST';
  }

  protected function isPatch(): bool
  {
    return $this->request === 'PATCH';
  }

  protected function isPut(): bool
  {
    return $this->request === 'PUT';
  }

  protected function isDelete(): bool
  {
    return $this->request === 'DELETE';
  }

  protected function getSession(): SessionManager
  {
    if (!$this->sessionService) {
      $this->sessionService = new SessionManager();
    }
    return $this->sessionService;
  }

  protected function getLoggedUser()
  {
    if (!$this->user) {
      $user_id = $this->getSession()->getUserID();
      if (!$user_id)
        return null;
      $this->user = (new UserRepository())->getUser(null, $user_id);
    }
    return $this->user;
  }


  protected function loginRequired()
  {
    if ($this->getSession()->isLoggedIn()) {
      return;
    }

    redirect('/login');
  }

  public function render(string $template = null, array $variables = [])
  {
    $templatePath = 'public/views/' . $template . '.php';

    if (!file_exists($templatePath)) {
      $templatePath = 'public/views/not_found.php';
    }

    extract($variables);

    ob_start();
    include $templatePath;
    print ob_get_clean();
  }
}