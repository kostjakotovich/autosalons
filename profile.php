<?php

require_once 'connection.php';

$sql = "SELECT commentID, name, email, comment FROM comments";
$conn = mysqli_connect($servername, $DBusername, $DBpassword, $dbname);
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

?>

<html>
    <head>
      <title>Formu aizpildīšana</title>
      <script src="../autosalons/js/script.js" defer></script>
    </head>
    <body>
        <button class="button" id="redirecttoindex" onClick="RedToComments()">Profils</button>
        <?php echo "<h1>Name: <h1>" . $row["name"]; ?>
        <?php echo "<h2>Email: <h2>" . $row["email"]; ?>
    </body>