<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="public/assets/favicon/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="public/css/app.css">
  <title><?php echo $book->getTitle() ?> </title>
  <style>

    .book-container {
      display: flex;
      flex-direction: column;
      padding: 10px;
      margin: 10px;
      background-color: #C8E6E1;
      border-radius: 10px;
    }

    .book-cover {
      width: 100%;
      max-width: 500px;
      height: auto;
      background-color: #ddd;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .book-details {
      flex: 1;
      padding: 10px;
    }

    .book-title {
      font-size: 2.5em;
      margin-bottom: 10px;
    }

    .book-author,
    .book-category {
      margin-bottom: 5px;
      font-style: italic;
      font-size: 1.3em;
    }

    .book-description {
      text-align: justify;
    }


    @media (min-width: 600px) {
      .book-container {
        flex-direction: row;
      }

      .book-cover {
        margin-right: 20px;
      }
    }
  </style>
</head>

<body>
  <?php include 'header.php'; ?>

  <div class="book-container">
    <div class="book-cover">
      <img src="<?= htmlspecialchars($book->getCoverUrlPath()) ?>.jpg" alt="Book Cover" style="width:100%;">
    </div>
    <div class="book-details">
      <div class="book-title"><?php echo $book->title; ?></div>
      <div class="book-author">by <?php echo $author->getFullName(); ?></div>
      <div class="book-category"><?php echo $category->name; ?></div>
      <div class="book-description">
        <strong>Details,</strong> <?php echo $book->summary; ?>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const loanButtons = document.querySelectorAll('.loan-book');
      const returnButtons = document.querySelectorAll('.return-book');
      const profileIcon = document.getElementById('profile-icon');
      const dropdownMenu = document.getElementById('dropdown-menu');

      loanButtons.forEach(button => {
        button.addEventListener('click', function() {
          const bookId = this.dataset.bookId;
          loanBook(bookId);
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

    function loanBook(bookId) {
      // Simulate a loan action
      console.log(`Loaning book with ID: ${bookId}`);
      // Remove the book from the recommended list and add to the loaned list
      const bookElement = document.querySelector(`.book[data-book-id="${bookId}"]`);
      const bookClone = bookElement.cloneNode(true);
      bookElement.remove();

      // Update the clone for the loaned list
      const btn = bookClone.querySelector('.loan-book');
      btn.classList.remove('loan-book');
      btn.classList.add('return-book');
      btn.innerText = 'Return book';
      btn.addEventListener('click', function() {
        returnBook(bookId);
      });

      document.getElementById('loaned-books-list').appendChild(bookClone);
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