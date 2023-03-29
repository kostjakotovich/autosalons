<?php
session_start();
require_once 'connection.php';

// Retrieve the user information based on the user ID stored in the session
$userID = $_SESSION["userID"];
$sql = "SELECT username, email FROM user WHERE userID = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$userID]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<html>
    <head>
      <title>Formu aizpildīšana</title>
      <script src="../autosalons/js/script.js" defer></script>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <?php require 'header.php'; ?>
        <h1>Name: <?php echo $user["username"]; ?></h1>
        <h2>Email: <?php echo $user["email"]; ?></h2>
    </body>
</html>