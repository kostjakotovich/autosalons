<?php
class database {
  private $DBconnection;

  function __construct(){
      try {
          $DBusername = "root";
          $DBpassword = "";
          $dbname = "mariadb";
          $this->DBconnection = new PDO("mysql:host=localhost;dbname=$dbname", $DBusername, $DBpassword);
          $this->DBconnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch(PDOException $ex) {
          echo "Exception error: " . $ex->getMessage();
          die($ex->getMessage());
      }
  }

  function getDBConnection() {
      return $this->DBconnection;
  }
}


$db = new database();
$connection = $db->getDBconnection();
?>