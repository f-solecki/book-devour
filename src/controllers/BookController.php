<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/BookRepository.php';
require_once __DIR__ . '/../repository/AuthorRepository.php';
require_once __DIR__ . '/../repository/LoanRepository.php';

class BookController extends AppController
{
    private $bookRepository;
    private $authorRepository;
    private $loansRepository;

    public function __construct()
    {
        parent::__construct();
        $this->bookRepository = new BookRepository();
        $this->authorRepository = new AuthorRepository();
        $this->loansRepository = new LoanRepository();
    }


    public function index()
    {
        if (!$this->isGet()) {
            echo "test2";
            return;
        }

        $this->loginRequired();
        $userId = $this->getSession()->getUserId();
        require_once __DIR__ . '/../repository/BookRepository.php';

        $this->bookRepository = new BookRepository();
        $books = $this->bookRepository->getBooks();
        $authors = $this->authorRepository->getAuthors();
        $loans = $this->loansRepository->getLoansByUserId($userId);
        return $this->render('books', ["books" => $books, "authors" => $authors, "loans" => $loans]);
    }

    public function delete_book()
    {
        if (!$this->isDelete() || !$this->getSession()->isLoggedIn()) {
            return;
        }

        // TODO: Implement
    }
}
