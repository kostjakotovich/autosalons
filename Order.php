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

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function getStatus() {
        return $this->status;
    }

    public function updateStatus($status, $orderID) {
        if (!empty($status)) {
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
    }
    
    public function createOrder($name, $surname, $telephone, $offerID, $detailsID) {
        if (strlen($name) > 20 || strlen($surname) > 20 || strlen($telephone) > 20) {
            return false;
        }
        
        $this->status = 'New';
        date_default_timezone_set('Europe/Riga');
        $this->orderDate = date("Y-m-d H:i:s");
        $this->name = $name;
        $this->surname = $surname;
        $this->telephone = $telephone;
        $this->orderOfferID = $offerID;
        $this->orderUserID = $_SESSION['userID'];
        
        if(isset($_SESSION["userID"])) { 
            $sql = "INSERT INTO `order` (`orderDate`, `status`, `orderOfferID`, `orderUserID`, `name`, `surname`, `telephone`, `orderDetailsID`) 
                    VALUES (:orderDate, :status, :orderOfferID, :orderUserID, :name, :surname, :telephone, :detailsID)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':orderDate', $this->orderDate);
            $stmt->bindValue(':status', $this->status);
            $stmt->bindValue(':orderOfferID', $this->orderOfferID);
            $stmt->bindValue(':orderUserID', $this->orderUserID);
            $stmt->bindValue(':name', $this->name);
            $stmt->bindValue(':surname', $this->surname);
            $stmt->bindValue(':telephone', $this->telephone);
            $stmt->bindValue(':detailsID', $detailsID);
            
            if ($stmt->execute()) {
            $_SESSION['order_success'] = "Your order has been sent successfully.";
            
            $userMain = new UserMain($this->orderUserID);
            
            $topicName = 'Orders';
            $topicID = $userMain->getNotificationTopicIDByName($topicName);
            
            $notificationText = "Your order has been successfully completed! Please wait while our staff contacts You. You can check your order <a href='profile.php'>here</a> in the 'My Orders' tab.";
            $userMain->addNotification($topicID, $notificationText);
            
            header("Location: index.php");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }           
        } else {
            header('location: loginPage.php');
        } 
    }
    
    
    public function deleteOrder($orderID) {
        $sql = "DELETE FROM `order` WHERE `orderID` = :orderID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':orderID', $orderID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $_SESSION['order_delete_success'] = "Order deleted successfully.";
            header("Location: ordersPage.php");
        } else {
            echo "Error deleting order: " . $stmt->errorInfo()[2];  
        }
    }

    public function getAllOrderInfo() {
        $sql = "SELECT o.*, u.*, off.*, car_colors.*, offInf.*, specific_details.*, transmission.*
                FROM `order` o
                LEFT JOIN `user` u ON o.orderUserID = u.userID
                LEFT JOIN `offers` off ON o.orderOfferID = off.offerID
                LEFT JOIN `offersinfo` offInf ON off.offerID = offInf.offersID
                INNER JOIN `specific_details` ON o.orderDetailsID = specific_details.detailsID
                INNER JOIN `transmission` ON transmission.transmissionID = specific_details.transmissionID
                INNER JOIN `car_colors` ON specific_details.colorID = car_colors.colorID
                ORDER BY `orderID` DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $orders;
    }    
    
    public function getOrderInfo($userID) {
        $this->orderUserID = $userID;
        $sql = "SELECT o.*, u.*, off.*, car_colors.*, offInf.*, specific_details.*, transmission.*
                FROM `order` o
                LEFT JOIN `user` u ON o.orderUserID = u.userID
                LEFT JOIN `offers` off ON o.orderOfferID = off.offerID
                LEFT JOIN `offersinfo` offInf ON off.offerID = offInf.offersID
                INNER JOIN `specific_details` ON o.orderDetailsID = specific_details.detailsID
                INNER JOIN `transmission` ON transmission.transmissionID = specific_details.transmissionID
                INNER JOIN `car_colors` ON specific_details.colorID = car_colors.colorID
                WHERE o.orderUserID = ?
                ORDER BY o.orderDate DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$this->orderUserID]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $orders;
    }
    
    public function getOrderSum($userID) {
        $this->orderUserID = $userID;
        $sql = "SELECT SUM(offInf.price) + SUM(car_colors.color_price) + SUM(transmission.transmission_price)as totalPrice
                FROM `order` o
                LEFT JOIN `user` u ON o.orderUserID = u.userID
                LEFT JOIN `offers` off ON o.orderOfferID = off.offerID
                LEFT JOIN `offersinfo` offInf ON off.offerID = offInf.offersID
                INNER JOIN `specific_details` ON o.orderDetailsID = specific_details.detailsID
                INNER JOIN `transmission` ON transmission.transmissionID = specific_details.transmissionID
                INNER JOIN `car_colors` ON specific_details.colorID = car_colors.colorID
                WHERE o.orderUserID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$this->orderUserID]);
        $sum = $stmt->fetch(PDO::FETCH_ASSOC);
        return $sum['totalPrice'];
    }    

    public function checkOrdersStatus() {
        $this->orderUserID = $_SESSION['userID'];
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


?>