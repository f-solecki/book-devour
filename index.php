<?php

require 'Routing.php';


$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);


// Home
Router::get('', 'BookController');

// Auth
Router::get('login', 'AuthController');
Router::post('login', 'AuthController');
Router::get('register', 'AuthController');
Router::post('register', 'AuthController');
Router::post('logout', 'AuthController');

// Books
Router::get('book', 'BookController');
Router::post('loan_book', 'BookController');
Router::delete('return_book', 'BookController');
Router::delete('delete_book', 'BookController');

// Users
Router::get('profile', 'UserController');
Router::delete('remove_account', 'UserController');

Router::run($path);
