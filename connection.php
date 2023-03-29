<?php
class database {
    private $DBusername = "root";
    private $DBpassword = "";
    private $dbname = "mariadb";
    private $DBconnection;

    //Connecting to the database, catching any errors that can be present.
    public function connect(){
        try{
            $this->DBconnection = new PDO("mysql:host=localhost; dbname=$this->dbname" , $this->DBusername, $this->DBpassword);
            $this->DBconnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->DBconnection;
        }
        catch(PDOException $ex){
            echo "Exception error: " . $ex->getMessage();// for testing purposes.
            die($ex->getMessage());
        }
    }
}
?>
