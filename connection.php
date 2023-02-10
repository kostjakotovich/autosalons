<?php
  $servername = "127.0.0.1";
  $username = "root";
  $password = "mariadb";
  $dbname = "mariadb";
  //Connecting to the database, catching any errors that can be present.
  try{
    $DBconnection = new PDO("mysql:host=$servername; dbname=$dbname" , $username, $password);
    $DBconnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  catch(PDOException $ex){
    echo "Exception error: " . $ex->getMessage();// for testing purposes.
    die($ex->getMessage());
  }

?>