<?php
class database {
    //Connecting to the database, catching any errors that can be present.
    protected function connect(){
      try{
        
        $DBusername = "root";
        $DBpassword = "";
        $dbname = "mariadb";
        $DBconnection = new PDO("mysql:host=localhost; dbname=$dbname" , $DBusername, $DBpassword);
        $DBconnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $DBconnection;
      }
      catch(PDOException $ex){
        echo "Exception error: " . $ex->getMessage();// for testing purposes.
        die($ex->getMessage());
      }
    }
}
?>