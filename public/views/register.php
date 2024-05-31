<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" href="public/assets/favicon/favicon.ico" type="image/x-icon">
  <title>BookDevour | Register</title>
</head>

<body>
  <?php include_once __DIR__ . '/shared/simple-header.php' ?>

  <div>
    <div>
      <div>
        <p>Register</p>
        <h1>Register to start using the app</h1>
      </div>

      <form action="/register" method="POST">
        <input type="text" id="firstName" name="firstName" required placeholder="First name" />

        <input type="text" id="lastName" name="lastName" required placeholder="Last name" />

        <input type="email" id="email" name="email" required placeholder="Email" />

        <input type="password" id="password" name="password" required placeholder="Password" />

        <input type="password" id="repeatedPassword" name="repeatedPassword" required placeholder="Repeat password" />

        <p>By pressing "Register" you agree to <a href="#">terms of service</a> and <a href="#">privacy policy</a>.</p>

        <?php if (isset($errorMessage)) { ?>
          <p><?php echo $errorMessage; ?></p>
        <?php } ?>

        <button type="submit">Register</button>

      </form>
      <a href="/login">Go to login</a>
    </div>
  </div>
</body>

</html>