<?php
require_once 'connection.php';

class Order {
    private $conn;

    private $orderID;
    private $orderDate;
    private $name;
    private $surname;
    private $telephone;
    private $status;
    private $orderOfferID;
    private $orderUserID;
    
    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function createOrder($name, $surname, $telephone, $orderOfferID, $orderUserID) {
        $this->name = $name;
        $this->surname = $surname;
        $this->telephone = $telephone;
        $this->status = 'New';
        $this->orderOfferID = $orderOfferID;
        $this->orderUserID = $orderUserID;
        $this->orderDate = date("Y-m-d H:i:s");

        $sql = "INSERT INTO `order` (orderDate, name, surname, telephone, status, orderOfferID, orderUserID) 
                VALUES (:orderDate, :name, :surname, :telephone, :status, :orderOfferID, :orderUserID)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':orderDate', $this->orderDate);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':surname', $this->surname);
        $stmt->bindParam(':telephone', $this->telephone);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':orderOfferID', $this->orderOfferID);
        $stmt->bindParam(':orderUserID', $this->orderUserID);
        $stmt->execute();
    }
}
?>
