<?php
  $servername = "localhost";
  $DBusername = "root";
  $DBpassword = "password";
  $dbname = "mariadb";
  //Connecting to the database, catching any errors that can be present.
  try{
    $DBconnection = new PDO("mysql:host=$servername; dbname=$dbname" , $DBusername, $DBpassword);
    $DBconnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  catch(PDOException $ex){
    echo "Exception error: " . $ex->getMessage();// for testing purposes.
    die($ex->getMessage());
  }

?>