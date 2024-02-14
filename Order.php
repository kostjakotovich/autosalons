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

    
    
    
    public function createOrder($name, $surname, $telephone, $offerID, $colorID) {
        if (strlen($name) > 20 || strlen($surname) > 20 || strlen($telephone) > 20) {
            // Handle the error if the length of input is greater than 20 characters
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
            $sql = "INSERT INTO `order` (`orderDate`, `status`, `orderOfferID`, `orderUserID`, `name`, `surname`, `telephone`, `colorID`) 
                    VALUES (:orderDate, :status, :orderOfferID, :orderUserID, :name, :surname, :telephone, :colorID)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':orderDate', $this->orderDate);
            $stmt->bindValue(':status', $this->status);
            $stmt->bindValue(':orderOfferID', $this->orderOfferID);
            $stmt->bindValue(':orderUserID', $this->orderUserID);
            $stmt->bindValue(':name', $this->name);
            $stmt->bindValue(':surname', $this->surname);
            $stmt->bindValue(':telephone', $this->telephone);
            // Привязываем значение colorID
            $stmt->bindValue(':colorID', $colorID);
            
            if ($stmt->execute()) {
                $_SESSION['order_success'] = "Your order has been sent successfully.";
                // Вставляем уведомление в таблицу
                $notificationText = "Your order has been successfully completed! Please wait while our staff contacts You. You can check your order <a href='profile.php'>here</a> in the 'My Orders' tab.";
                $insertNotification = $this->conn->prepare("INSERT INTO notifications (userID, message) VALUES (:userID, :message)");
                $insertNotification->execute(array(':userID' => $_SESSION['userID'], ':message' => $notificationText));

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
        $sql = "SELECT o.orderID, o.orderDate, o.name, o.surname, o.telephone, o.status, u.username, u.email, off.manufacturer, off.type, CarCol.color, offInf.price, CarCol.color_price
                FROM `order` o
                LEFT JOIN `user` u ON o.orderUserID = u.userID
                LEFT JOIN `offers` off ON o.orderOfferID = off.offerID
                LEFT JOIN `offersinfo` offInf ON off.offerID = offInf.offersID
                INNER JOIN `car_colors` CarCol ON o.colorID = CarCol.colorID
                order by `orderID` DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $orders;
    }    
      

    public function getOrderInfo($userID) {
        $this->orderUserID = $userID;
        $sql = "SELECT o.orderID, o.orderDate, o.name, o.surname, o.telephone, o.status, u.username, u.email, off.manufacturer, off.type, CarCol.color, offInf.price, CarCol.color_price
                FROM `order` o
                LEFT JOIN `user` u ON o.orderUserID = u.userID
                LEFT JOIN `offers` off ON o.orderOfferID = off.offerID
                LEFT JOIN `offersinfo` offInf ON off.offerID = offInf.offersID
                INNER JOIN `car_colors` CarCol ON o.colorID = CarCol.colorID
                WHERE o.orderUserID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$this->orderUserID]);
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $orders;
    }

    public function getOrderSum($userID) {
        $this->orderUserID = $userID;
        $sql = "SELECT SUM(offInf.price) + SUM(CarCol.color_price) as totalPrice
                FROM `order` o
                LEFT JOIN `user` u ON o.orderUserID = u.userID
                LEFT JOIN `offers` off ON o.orderOfferID = off.offerID
                LEFT JOIN `offersinfo` offInf ON off.offerID = offInf.offersID
                INNER JOIN `car_colors` CarCol ON o.colorID = CarCol.colorID
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