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
  <?php
  $isAdmin = $isAdmin;
  include 'header.php'; ?>

  <div class="container">
    <?php if (!empty($loans)) { ?>

      <div class="books">
        <div class="books-title">Your books</div>
        <div class="books-scrollable-list" id="loaned-books-list">
          <?php
          foreach ($loans as $loan) :
            $loanedBook = $loan;
            $isLoanExpired = strtotime($loan->getReturnDate()) < time();
          ?>
            <div class="book" data-book-id="<?= $loanedBook->getId() ?>">
              <img class="cover_photo_small" src="<?= htmlspecialchars($loanedBook->getCoverUrlPath()) ?>.jpg" alt="book cover">
              <div class="book-info">
                <div class="book-header">
                  <div class="title"><?= htmlspecialchars($loanedBook->getTitle()) ?></div>
                  <a class="info-icon" href="book?id=<?= $loanedBook->getId() ?>"><img class="info-icon" src="public/assets/images/info.svg" alt="info" /></a>
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
    <?php } ?>


    <?php
    if (!empty($recommendedBooks)) {
      $booksWithoutLoans = array_filter($recommendedBooks, function ($book) use ($allLoans) {
        foreach ($allLoans as $loan) {
          if ($loan->getBookId() === $book->getId()) {
            return false;
          }
        }
        return true;
      });

      if (!empty($booksWithoutLoans)) : ?>
        <div class='books'>
          <div class='books-title'>Recommended for you</div>
          <div class='books-scrollable-list' id='recommended-books-list'>


            <?php
            foreach ($booksWithoutLoans as $book) : ?>
              <div class="book" data-book-id="<?= $book->getId() ?>">
                <img class="cover_photo_small" src="<?= htmlspecialchars($book->getCoverUrlPath()) ?>.jpg" alt="book cover">
                <div class="book-info">
                  <div class="book-header">
                    <div class="title"><?= htmlspecialchars($book->getTitle()) ?></div>
                    <a class="info-icon" href="book?id=<?= $book->getId() ?>"><img class="info-icon" src="public/assets/images/info.svg" alt="info" /></a>
                  </div>
                  <p class="author-name"><?= htmlspecialchars($authors[$book->getAuthorId() - 1]->getFirstName()) ?> <?= htmlspecialchars($authors[$book->getAuthorId() - 1]->getLastName()) ?></p>
                  <p class="category"><?= htmlspecialchars($categories[$book->getCategoryId() - 1]->getName()) ?></p>
                  <button class="btn loan-book" data-book-id="<?= $book->getId() ?>">Loan book</button>
                </div>
              </div>
            <?php endforeach; ?>

          </div>
        </div>
      <?php endif; ?>
    <?php } ?>

    <div class="books">
      <div class="books-title">All available books</div>
      <table class="books-table" cellspacing="0" cellpadding="0">
        <tr class="list-row">
          <th class="list-header ">Title</th>
          <th class="list-header mobile-hide">Author</th>
          <th class="list-header mobile-hide">Category</th>
          <th class="list-header"></th>
        </tr>
        <?php
        $booksWithoutLoans = array_filter($books, function ($book) use ($allLoans) {
          foreach ($allLoans as $loan) {
            if ($loan->getBookId() === $book->getId()) {
              return false;
            }
          }
          return true;
        });

        foreach ($booksWithoutLoans as $book) : ?>
          <tr class="list-row" data-book-id="<?= $book->getId() ?>">
            <td class="list-cell title-cell"><?= htmlspecialchars($book->getTitle()) ?></td>
            <td class="list-cell mobile-hide"><?= htmlspecialchars($authors[$book->getAuthorId() - 1]->getFirstName()) ?> <?= htmlspecialchars($authors[$book->getAuthorId() - 1]->getLastName()) ?></td>
            <td class="list-cell mobile-hide"><?= htmlspecialchars($categories[$book->getCategoryId() - 1]->getName()) ?></td>
            <td class="action-cell">
              <a class="info-icon" style="margin-right:10px" href="book?id=<?= $book->getId() ?>"><img class="info-icon" src="public/assets/images/info.svg" alt="info" /></a>
              <button class="btn loan-book" data-book-id="<?= $book->getId() ?>">Loan book</button>
              <?php if ($isAdmin) : ?>
                <button class="delete-btn" data-book-id="<?= $book->getId() ?>"><img class="delete-icon" src="public/assets/images/trash.svg" alt="delete" /></button>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>
  </div>

  <script src="public/js/books.js"></script>
</body>

</html>