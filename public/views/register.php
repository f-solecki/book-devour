<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="public/assets/favicon/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="public/css/app.css">
  <link rel="stylesheet" type="text/css" href="public/css/auth.css">
  <title>BookDevour | Register</title>
</head>

<body>
  <div class="wrapper">
    <div class="container">
      <div class="logo"><img src="public/assets/images/logo.jpg" alt="LOGO"></div>
      <h1>Register to start using the app</h1>

      <form action="/register" method="POST">
        <div class="form-wrapper">
          <input type="text" id="firstName" name="firstName" required placeholder="First name" />
          <input type="text" id="lastName" name="lastName" required placeholder="Last name" />
          <input type="email" id="email" name="email" required placeholder="Email" />
          <input type="password" id="password" name="password" required placeholder="Password" />
          <input type="password" id="repeatedPassword" name="repeatedPassword" required placeholder="Repeat password" />
          <p class="terms">By pressing "Register" you agree to <a href="#">terms of service</a> and <a href="#">privacy policy</a>.</p>

          <?php if (isset($errorMessage)) { ?>
            <p class="error-message"><?php echo $errorMessage; ?></p>
          <?php } ?>

          <button type="submit" class="register-button">Register</button>
        </div>
      </form>

      <div class="login-link">Already have an account? <a href="/login">Login</a></div>
    </div>
  </div>
</body>

</html>