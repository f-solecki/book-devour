<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="public/assets/favicon/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="public/css/app.css">
  <link rel="stylesheet" type="text/css" href="public/css/auth.css">
  <title>BookDevour | Login</title>
</head>

<body>
  <div class="wrapper">

    <div class="container">
      <div class="logo"><img src="public/assets/images/logo.jpg" alt="LOGO"></div>
      <h1>Login</h1>

      <form action="/login" method="POST">
        <div class="form-wrapper">
          <input type="email" id="email" name="email" required placeholder="Email" />
          <input type="password" id="password" name="password" required placeholder="Password" />

          <?php if (isset($errorMessage)) { ?>
            <p class="error-message"><?php echo $errorMessage; ?></p>
          <?php } ?>

          <button type="submit" class="login-button">Login</button>
        </div>
      </form>

      <div class="register-link">Don't have an account? <a href="/register">Register</a></div>
    </div>
  </div>
</body>

</html>