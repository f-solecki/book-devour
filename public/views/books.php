<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="public/assets/favicon/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="public/css/app.css">
  <link rel="stylesheet" type="text/css" href="public/css/books.css">
  <title>Books</title>
</head>

<body>
  <?php include 'header.php'; ?>

  <div class="container">
    <div class="books">
      <div class="books-header">
        <div class="books-title">Your books</div>
        <a href="your_books.php">See all</a>
      </div>
      <div class="books-scrollable-list" id="loaned-books-list">
        <?php
        foreach ($loans as $loan) :
          $loanedBook = $books[$loan->getBookId()];
          $isLoanExpired = strtotime($loan->getReturnDate()) < time();
        ?>
          <div class="book" data-book-id="<?= $loanedBook->getId() ?>">
            <img class="cover_photo_small" src="<?= htmlspecialchars($loanedBook->getCoverUrlPath()) ?>.jpg" alt="book cover">
            <div class="book-info">
              <div class="book-header">
                <div class="title"><?= htmlspecialchars($loanedBook->getTitle()) ?></div>
                <a class="info-icon" href="book?id=<?= $loanedBook->getId() ?>"><i class="fa-solid fa-circle-info"></i></a>
                </div>
              <p class="author-name"><?= htmlspecialchars($authors[$loanedBook->getAuthorId() - 1]->getFirstName()) ?> <?= htmlspecialchars($authors[$loanedBook->getAuthorId() - 1]->getLastName()) ?></p>
              <?php if ($isLoanExpired) : ?>
                <p class="end-loan" style="color: red;">Loan ends on: <?= htmlspecialchars($loan->getReturnDate()) ?></p>
              <?php else : ?>
                <p class="end-loan" style="color: green;">Loan ends on: <?= htmlspecialchars($loan->getReturnDate()) ?></p>
              <?php endif; ?>
              <button class="btn return-book" data-book-id="<?= $loanedBook->getId() ?>">Return book</button>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="books">
      <div class="books-title">Recommended for you</div>
      <div class="books-scrollable-list" id="recommended-books-list">
        <?php
        $booksWithoutLoans = array_filter($recommendedBooks, function ($book) use ($loans) {
          foreach ($loans as $loan) {
            if ($loan->getBookId() === $book->getId()) {
              return false;
            }
          }
          return true;
        });

        foreach ($booksWithoutLoans as $book) : ?>
          <a class="book" href="book?id=<?= $loanedBook->getId() ?>">
            <img class="cover_photo_small" src="<?= htmlspecialchars($book->getCoverUrlPath()) ?>.jpg" alt="book cover">
            <div class="book-info">
              <div class="title"><?= htmlspecialchars($book->getTitle()) ?></div>
              <p class="author-name"><?= htmlspecialchars($authors[$book->getAuthorId() - 1]->getFirstName()) ?> <?= htmlspecialchars($authors[$book->getAuthorId() - 1]->getLastName()) ?></p>
              <p class="category"><?= htmlspecialchars($categories[$book->getCategoryId() - 1]->getName()) ?></p>
              <button class="btn loan-book" data-book-id="<?= $book->getId() ?>">Loan book</button>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="books">
      <div class="books-title">All books</div>
      <table class="books-table" cellspacing="0" cellpadding="0">
        <tr class="list-row">
          <th class="list-header">Title</th>
          <th class="list-header">Author</th>
          <th class="list-header">Category</th>
          <th class="list-header"></th>
        </tr>
        <?php
        $booksWithoutLoans = array_filter($books, function ($book) use ($loans) {
          foreach ($loans as $loan) {
            if ($loan->getBookId() === $book->getId()) {
              return false;
            }
          }
          return true;
        });

        foreach ($booksWithoutLoans as $book) : ?>
          <tr class="list-row" data-book-id="<?= $book->getId() ?>">
            <td class="list-cell title-cell"><?= htmlspecialchars($book->getTitle()) ?></td>
            <td class="list-cell"><?= htmlspecialchars($authors[$book->getAuthorId() - 1]->getFirstName()) ?> <?= htmlspecialchars($authors[$book->getAuthorId() - 1]->getLastName()) ?></td>
            <td class="list-cell"><?= htmlspecialchars($categories[$book->getCategoryId() - 1]->getName()) ?></td>
            <td class="action-cell">
              <button class="btn loan-book" data-book-id="<?= $book->getId() ?>">Loan book</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function(event) {
      const loanButtons = document.querySelectorAll('.loan-book');
      const returnButtons = document.querySelectorAll('.return-book');
      const profileIcon = document.getElementById('profile-icon');
      const dropdownMenu = document.getElementById('dropdown-menu');

      document.querySelectorAll('.loan-book').forEach(button => {
        button.addEventListener('click', function(event) {
          event.preventDefault(); // Prevent the default anchor behavior
          event.stopPropagation(); // Stop the click event from bubbling up to the <a> tag
          loanBook(this.getAttribute('data-book-id'));
        });
      });

      loanButtons.forEach(button => {
        button.addEventListener('click', function() {
          const bookId = this.dataset.bookId;
          const userId = <?= $userId ?>;
          loanBook(bookId, userId);
        });
      });

      returnButtons.forEach(button => {
        button.addEventListener('click', function() {
          const bookId = this.dataset.bookId;
          returnBook(bookId);
        });
      });

      profileIcon.addEventListener('click', function() {
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
      });

      document.addEventListener('click', function(event) {
        if (!profileIcon.contains(event.target) && !dropdownMenu.contains(event.target)) {
          dropdownMenu.style.display = 'none';
        }
      });
    });

    function loanBook(bookId, userId) {
      // Simulate a loan action
      console.log(`Loaning book with ID: ${bookId}`);

      fetch('/loan_book', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          bookId: bookId,
          userId: userId
        }),
      }).then((response) => {
        if (response.ok) {
          closeModal(deleteModal);
          location.reload();
        } else {
          alert("Error deleting exercise");
        }
      });
    }

    function returnBook(bookId) {
      // Simulate a return action
      console.log(`Returning book with ID: ${bookId}`);
      // Remove the book from the loaned list and add to the recommended list
      const bookElement = document.querySelector(`.book[data-book-id="${bookId}"]`);
      const bookClone = bookElement.cloneNode(true);
      bookElement.remove();

      // Update the clone for the recommended list
      const btn = bookClone.querySelector('.return-book');
      btn.classList.remove('return-book');
      btn.classList.add('loan-book');
      btn.innerText = 'Loan book';
      btn.addEventListener('click', function() {
        loanBook(bookId);
      });

      document.getElementById('recommended-books-list').appendChild(bookClone);
    }
  </script>
</body>

</html>