<?php
require_once 'connection.php';
require_once 'Offer.php';
require_once 'User.php';


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

    public function __construct($offerID, $userID) {
        $this->conn = (new Database())->connect();
        $this->orderOfferID = $offerID;
        $this->orderUserID = $userID;
    }
    
    
    public function createOrder($name, $surname, $telephone, $offerID) {
        $this->status = 'New';
        $this->orderDate = date("Y-m-d H:i:s");
        $this->name = $name;
        $this->surname = $surname;
        $this->telephone = $telephone;
        $this->orderOfferID = $_POST['offerID'];
        $this->orderUserID = $_SESSION['userID'];
        
        $sql = "INSERT INTO `order` (`orderDate`, `status`, `orderOfferID`, `orderUserID`, `name`, `surname`, `telephone`) 
                VALUES (:orderDate, :status, :orderOfferID, :orderUserID, :name, :surname, :telephone)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':orderDate', $this->orderDate);
        $stmt->bindValue(':status', $this->status);
        $stmt->bindValue(':orderOfferID', $this->orderOfferID);
        $stmt->bindValue(':orderUserID', $this->orderUserID);
        $stmt->bindValue(':name', $this->name);
        $stmt->bindValue(':surname', $this->surname);
        $stmt->bindValue(':telephone', $this->telephone);
        $stmt->execute();
        header('location: offerPage.php');
    }
    
    

    public function getOrderInfo() {
        $sql = "SELECT o.orderID, o.orderDate, o.name, o.surname, o.telephone, o.status, u.username, u.email, off.manufacturer, off.type, offInf.price
                FROM `order` o
                LEFT JOIN `user` u ON o.orderUserID = u.userID
                LEFT JOIN `offers` off ON o.orderOfferID = off.offerID
                LEFT JOIN `offersinfo` offInf ON off.offerID = offInf.offersID
                WHERE o.orderUserID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$this->orderUserID]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $orders;
    }

    public function setUserIDFromSession($userID) {
        $this->orderUserID = $userID;
    }
    
}
?>
