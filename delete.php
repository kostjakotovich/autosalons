<?php

session_start(); //Start the session.
require_once 'connection.php'; //Require connection file to connect to database.
$sql = "SELECT * FROM comments ORDER BY commentID DESC";

if(isset($_GET['commentID'])) {
   $id = $_GET['commentID'];
   $delete = "DELETE FROM `comments` WHERE `commentID` ='$id'";
   $result = $DBconnection->query($delete);
      header("Location: index.php?success=successfully deleted");

}else {
   header("Location: index.php?error=smth gone wrong");
}

?>