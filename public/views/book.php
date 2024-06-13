<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="public/assets/favicon/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="public/css/app.css">
  <link rel="stylesheet" href="public/css/books.css">
  <link rel="stylesheet" href="public/css/book.css">

  <title><?php echo $book->getTitle() ?> </title>
</head>

<body>
  <?php
  $isAdmin = $isAdmin;
  include 'header.php';
  ?>

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

      <div class="book-action-button">
        <?php
        $loanedBookIds = array();
        foreach ($loans as $loan) {
          $loanedBookIds[] = $loan->book_id;
        }

        if (in_array($book->id, $loanedBookIds)) : ?>
          <button class="btn return-book" data-book-id="<?= $book->id ?>">Return book</button>
        <?php else : ?>
          <button class="btn loan-book" data-book-id="<?= $book->id ?>">Loan book</button>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <script src="public/js/books.js"></script>
</body>

</html>