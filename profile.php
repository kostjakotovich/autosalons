<?php

require_once 'connection.php';

require 'header.php';

$db = new database();
$conn = $db->getDBConnection();

$sql = "SELECT userID, username, email, password FROM user";
$result = $conn->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);

?>

<html>
    <head>
      <title>Formu aizpildīšana</title>
      <script src="../autosalons/js/script.js" defer></script>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <button class="button" id="redirecttoindex" onClick="RedToComments()">Home page</button>
        <?php echo "<h1>Name: <h1>" . $row["username"]; ?>
        <?php echo "<h2>Email: <h2>" . $row["email"]; ?>
    </body>