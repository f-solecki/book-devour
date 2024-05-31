<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../utils/utils.php';

class AuthController extends AppController
{
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }

    public function register()
    {
        if ($this->isGet()) {
            return $this->render('register');
        }

        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $repeatedPassword = $_POST['repeatedPassword'];

        if ($password !== $repeatedPassword) {
            $this->render('register', ['errorMessage' => 'Passwords are not the same!']);
            return;
        }


        try {
            $this->userRepository->createUser([
                'firstName' => $firstName,
                'lastName' => $lastName,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_BCRYPT)
            ]);
        } catch (Exception $e) {
            if (strpos($e->getMessage(), 'unique_email') !== false) {
                $this->render('register', ['errorMessage' => 'User with this email already exists!']);
            } else {
                $this->render('register', ['errorMessage' => 'Something went wrong! Try later!']);
            }
            return;
        }

        redirect('/login');
    }

    public function login()
    {
        if ($this->isGet()) {
            return $this->render('login');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->userRepository->getUser($email);

        if ($user === null || !password_verify($password, $user->getPassword())) {
            $this->render('login', ['errorMessage' => 'Wrong email or password!']);
            return;
        }

        $this->getSession()->setUserID($user->getId());

        redirect('/');
    }

    public function logout()
    {
        $this->getSession()->destroy();
        redirect('/login');
    }
}