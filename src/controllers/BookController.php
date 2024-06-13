<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/BookRepository.php';
require_once __DIR__ . '/../repository/AuthorRepository.php';
require_once __DIR__ . '/../repository/LoanRepository.php';
require_once __DIR__ . '/../repository/CategoryRepository.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class BookController extends AppController
{
    private $bookRepository;
    private $authorRepository;
    private $loansRepository;
    private $categoryRepository;
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->bookRepository = new BookRepository();
        $this->authorRepository = new AuthorRepository();
        $this->loansRepository = new LoanRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->userRepository = new UserRepository();
    }


    public function index()
    {
        if (!$this->isGet()) {
            return;
        }

        $this->loginRequired();

        $userId = $this->getSession()->getUserId();
        $isAdmin = $this->userRepository->isUserAdmin($userId);
        $books = $this->bookRepository->getBooks();
        $authors = $this->authorRepository->getAuthors();
        $loans = $this->loansRepository->getLoansByUserId($userId);
        $allLoans = $this->loansRepository->getLoanedBooks();
        $categories = $this->categoryRepository->getCategories();
        $recommendedBooks = $this->bookRepository->getRecommendedUserBooks($userId);
        return $this->render('books', ["isAdmin" => $isAdmin, "books" => $books, "authors" => $authors, "loans" => $loans, "allLoans" => $allLoans, "categories" => $categories, "recommendedBooks" => $recommendedBooks]);
    }

    public function book()
    {
        if (!$this->isGet()) {
            return;
        }

        $this->loginRequired();
        $id = $_GET['id'];
        $userId = $this->getSession()->getUserId();
        $isAdmin = $this->userRepository->isUserAdmin($userId);
        $book = $this->bookRepository->getBookById($id);
        $author = $this->authorRepository->getAuthorById($book->getAuthorId());
        $category = $this->categoryRepository->getCategoryById($book->getCategoryId());
        $loans = $this->loansRepository->getLoanedBooks();

        return $this->render('book', ["isAdmin" => $isAdmin, 'book' => $book, 'author' => $author, 'category' => $category, 'loans' => $loans]);
    }


    public function loan_book()
    {
        if (!$this->isPost() || !$this->getSession()->isLoggedIn()) {
            http_response_code(401);
            return;
        }
        $userId = $this->getSession()->getUserId();
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['book_id'])) {
            http_response_code(404);
            return;
        }

        if ($this->loansRepository->isBookLoaned($data['book_id'], $userId)) {
            http_response_code(409);
            return;
        }

        $loan = new Loan(
            null,
            $data['book_id'],
            $userId,
            date('Y-m-d'),
            date('Y-m-d', strtotime('+1 month'))
        );

        $this->loansRepository->loanBook($loan);
        http_response_code(200);
    }

    public function return_book()
    {
        if (!$this->isDelete() || !$this->getSession()->isLoggedIn()) {
            http_response_code(401);
            return;
        }
        $userId = $this->getSession()->getUserId();
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['book_id'])) {
            http_response_code(404);
            return;
        }

        if (!$this->loansRepository->isBookLoaned($data['book_id'], $userId)) {
            http_response_code(409);
            return;
        }

        $this->loansRepository->returnBook($data['book_id'], $userId);
        http_response_code(200);
    }


    public function delete_book()
    {
        $userId = $this->getSession()->getUserId();

        if (!$this->isDelete() || !$this->getSession()->isLoggedIn() || !$this->userRepository->isUserAdmin($userId)) {
            http_response_code(401);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['book_id'])) {
            http_response_code(404);
            return;
        }

        $this->bookRepository->deleteBook($data['book_id']);
        http_response_code(200);
    }
}
