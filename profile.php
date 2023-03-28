<?php

require_once 'connection.php';

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
    </head>
    <body>
        <button class="button" id="redirecttoindex" onClick="RedToComments()">Home page</button>
        <?php echo "<h1>Name: <h1>" . $row["username"]; ?>
        <?php echo "<h2>Email: <h2>" . $row["email"]; ?>
    </body>