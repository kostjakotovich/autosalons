<?php
session_start();
require_once 'User.php';
require_once 'connection.php';
if(isset($_SESSION["userID"])) {
  $userID = $_SESSION["userID"];
  $user = new User($userID);
  $userInfo = $user->getUserInfo();
  if(isset($userInfo)){
      $username = $userInfo['username'];
      $email = $userInfo['email'];
  }
} else {
  // redirect the user to the login page or show an error message
}



?>

<html>
    <head>
      <title>User Profile</title>
    </head>
    <body>
    <?php
      require 'header.php';
    ?>
      <h1>User Profile</h1>
      <?php if(isset($userInfo)): ?>
      <p>Name: <?php echo $username; ?></p>
      <p>Email: <?php echo $email; ?></p>
      <?php endif; ?>
    </body>
</html>

