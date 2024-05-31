<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="public/assets/favicon/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="public/css/app.css">
  <link rel="stylesheet" type="text/css" href="public/css/books.css">
  <title>Books</title>
</head>

<body>
  <div class="container">
    <div class="books">
      <div class="books-title">Your books</div>
      <div class="books-scrollable-list">
        <?php
        foreach ($loans as $loan) {
          $loanedBook = $books[$loan->getBookId() - 1];
          echo '<div class="book">';
          echo '<img class="cover_photo_small" src="' . $loanedBook->getCoverUrlPath() . '.jpg" alt="book cover">';
          echo '<div class="book-info">';
          echo '<div class="title">' . $loanedBook->getTitle() . '</div>';
          echo '<p class="author-name">' . $authors[$loanedBook->getAuthorId() - 1]->getFirstName() . ' ' . $authors[$loanedBook->getAuthorId() - 1]->getLastName() . '</p>';
          echo '</div>';
          echo '</div>';
        }
        ?>
      </div>
    </div>
    <div class="books">
      <div class="books-title">Recommended for you</div>
      <div class="books-scrollable-list">
        <?php
        $booksWithoutLoans = array_filter($books, function ($book) use ($loans) {
          foreach ($loans as $loan) {
            if ($loan->getBookId() === $book->getId() - 1) {
              return false;
            }
          }
          return true;
        });

        foreach ($booksWithoutLoans as $book) {
          echo '<div class="book">';
          echo '<img class="cover_photo_small" src="' . $book->getCoverUrlPath() . '.jpg" alt="book cover">';
          echo '<div class="book-info">';
          echo '<div class="title">' . $book->getTitle() . '</div>';
          echo '<p class="author-name">' . $authors[$book->getAuthorId() - 1]->getFirstName() . ' ' . $authors[$book->getAuthorId() - 1]->getLastName() . '</p>';
          echo '</div>';
          echo '</div>';
        }
        ?>
      </div>
    </div>

    <div class="books">
      All books
    </div>
  </div>
</body>

</html>