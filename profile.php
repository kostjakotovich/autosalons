<?php
session_start();
require_once 'connection.php';
require_once 'User.php';

if(isset($_SESSION["userID"])) {
  $userID = $_SESSION["userID"];
  $user = new User($userID);
  $userInfo = $user->getUserInfo();
  if(isset($userInfo)){
      $username = $userInfo['username'];
      $email = $userInfo['email'];
  }
} else {
  header('location: loginPage.php');
}

?>

<html>
    <head>
      <script src="../autosalons/js/script.js" defer></script>
      <link rel="stylesheet" href="css/homepage.css">
      <title>User Profile</title>
    </head>
    <body>
      <?php require 'header.php'; ?>
      <h1>User Profile</h1>
      <?php if(isset($userInfo)): ?>
      <p>Name: <?php echo $username; ?></p>
      <p>Email: <?php echo $email; ?></p>
      <?php endif; ?>
    </body>
</html>
