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
    private $orderUserID;
    private $orderOfferID;

    public function __construct($offerID, $userID) {
        $this->conn = (new Database())->connect();
        $this->orderOfferID = $offerID;
        $this->orderUserID = $userID;
    }

    public function getStatus() {
        return $this->status;
    }

    public function updateStatus($status, $orderID) {
        $this->orderID = $orderID;
        $this->status = $status;
        $sql = "UPDATE `order` SET `status` = :status WHERE `orderID` = :orderID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':status', $this->status);
        $stmt->bindValue(':orderID', $this->orderID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $_SESSION['order_status_success'] = "Order status changed successfully.";
        } else {
            echo "Error updating order status: " . $stmt->errorInfo()[2];
        }
    }

    
    
    
    public function createOrder($name, $surname, $telephone, $offerID) {
        $this->status = 'New';
        $this->orderDate = date("Y-m-d H:i:s");
        $this->name = $name;
        $this->surname = $surname;
        $this->telephone = $telephone;
        $this->orderOfferID = $_POST['offerID'];
        $this->orderUserID = $_SESSION['userID'];
        
        if(isset($_SESSION["userID"])) { 
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
            if ($stmt->execute()) {
                $_SESSION['order_success'] = "Your order has been sent successfully.";
                header("Location: index.php");
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
        else{
            header('location: loginPage.php');
        } 
          
    }
    
    

    public function getAllOrderInfo() {
        $sql = "SELECT o.orderID, o.orderDate, o.name, o.surname, o.telephone, o.status, u.username, u.email, off.manufacturer, off.type, offInf.price
                FROM `order` o
                LEFT JOIN `user` u ON o.orderUserID = u.userID
                LEFT JOIN `offers` off ON o.orderOfferID = off.offerID
                LEFT JOIN `offersinfo` offInf ON off.offerID = offInf.offersID
                order by `status` DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $orders;
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

    public function checkOrdersStatus() {
        $query = "SELECT COUNT(*) as count FROM `order` WHERE orderUserID=:userID AND (status='New' OR status='In progress')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userID', $this->orderUserID);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }
    

    public function setUserIDFromSession($userID) {
        $this->orderUserID = $userID;
    }
    
}

if (isset($_POST['submit_order'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $telephone = $_POST['telephone'];
    echo "<script>event.preventDefault();</script>";
    if (isset($_SESSION['userID'])) {
        $order = new Order($userID, $offerID);
        $order->createOrder($offerID, $_SESSION['userID'], $_POST['name'], $_POST['surname'], $_POST['telephone']);
    } else {
      // Handle the case where the user is not logged in
    }
  }
?>
