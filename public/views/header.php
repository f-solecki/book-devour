<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="public/css/header.css">
</head>

<body>
  <header class="header">
    <div class="logo">
      <a href="/">
        <img src="public/assets/images/logo.jpg" alt="Logo">
      </a>
    </div>
    <div class="right-side">
      <?php if ($isAdmin) : ?>
        <div class="is-admin">
          Admin
        </div>
      <?php endif; ?>
      <div class="profile">
        <i class="fas fa-user profile-icon" id="profile-icon"></i>
        <div class="dropdown-menu" id="dropdown-menu">
          <form action="/logout" method="POST" class="logout-form">
            <button type="submit" class="logout-button text-xl">
              Logout
            </button>
          </form>
        </div>
      </div>
    </div>
  </header>

  <script src="public/js/header.js"></script>
</body>

</html>