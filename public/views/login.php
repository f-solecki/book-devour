<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="public/assets/favicon/favicon.ico" type="image/x-icon">
  <title>BookDevour | Login</title>
</head>

<body>

  <div>
    <form action="/login" method="POST">
      <input type="email" id="email" name="email" required placeholder="Email" />

      <input type="password" id="password" name="password" required placeholder="Password" />

      <?php if (isset($errorMessage)) { ?>
        <p><?php echo $errorMessage; ?></p>
      <?php } ?>

      <button type="submit">Login</button>

    </form>
    <a href="/register">I don't have an account</a>
  </div>
</body>

</html>