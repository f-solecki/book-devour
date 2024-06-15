<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="public/assets/favicon/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="public/css/app.css">
  <link rel="stylesheet" href="public/css/profile.css">
  <title>Profile</title>
</head>

<body>
  <?php
  $isAdmin = $isAdmin;
  include 'header.php';
  ?>

  <div class="profile-container">
    <div class="profile-details">
      <div class="left-column">
        <div class="profile-image">
          <img src="public/assets/images/profile.jpg" alt="Profile Image">
        </div>
        <div class="profile-info">
          <div class="profile-name"><?php
                                    echo $user->getFullName(); ?></div>
          <div class="profile-email"><?php echo $user->email; ?></div>
          <div class="profile-phone"><?php echo $user->phone; ?></div>
          <div class="profile-role"><?php
                                    if ($isAdmin) {
                                      echo "Admin";
                                    } else {
                                      echo "User";
                                    }

                                    ?>
          </div>
        </div>
      </div>
      <div class="right-column">
        <div class="profile-actions">
          <button data-user-id="<?= $user->id ?>" class='btn remove-account'>Remove account</button>
        </div>
      </div>
    </div>

  </div>
  <script src="public/js/profile.js"></script>
</body>

</html>