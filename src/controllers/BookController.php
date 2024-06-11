<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/BookRepository.php';
require_once __DIR__ . '/../repository/AuthorRepository.php';
require_once __DIR__ . '/../repository/LoanRepository.php';
require_once __DIR__ . '/../repository/CategoryRepository.php';

class BookController extends AppController
{
    private $bookRepository;
    private $authorRepository;
    private $loansRepository;
    private $categoryRepository;

    public function __construct()
    {
        parent::__construct();
        $this->bookRepository = new BookRepository();
        $this->authorRepository = new AuthorRepository();
        $this->loansRepository = new LoanRepository();
        $this->categoryRepository = new CategoryRepository();
    }


    public function index()
    {
        if (!$this->isGet()) {
            return;
        }

        $this->loginRequired();
        $userId = $this->getSession()->getUserId();
        require_once __DIR__ . '/../repository/BookRepository.php';

        $books = $this->bookRepository->getBooks();
        $authors = $this->authorRepository->getAuthors();
        $loans = $this->loansRepository->getLoansByUserId($userId);
        $categories = $this->categoryRepository->getCategories();
        $recommendedBooks = $this->bookRepository->getRecommendedUserBooks($userId);
        return $this->render('books', ["books" => $books, "authors" => $authors, "loans" => $loans, "categories" => $categories, "recommendedBooks" => $recommendedBooks]);
    }

    public function book()
    {
        if (!$this->isGet()) {
            return;
        }

        $this->loginRequired();
        $id = $_GET['id'];
        $book = $this->bookRepository->getBookById($id);
        $author = $this->authorRepository->getAuthorById($book->getAuthorId());
        $category = $this->categoryRepository->getCategoryById($book->getCategoryId());

        return $this->render('book', ['book' => $book, 'author' => $author, 'category' => $category]);
    }

    public function delete_book()
    {
        if (!$this->isDelete() || !$this->getSession()->isLoggedIn()) {
            return;
        }

        // TODO: Implement
    }
}
