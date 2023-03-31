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
    
    // Метод для получения информации о заказе по его ID
    public function getOrder($orderID) {
        $sql = "SELECT * FROM `order` WHERE orderID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$orderID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
    // Метод для получения всех заказов
    public function getAllOrders() {
        $sql = "SELECT * FROM `order`";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    // Метод для создания нового заказа
    public function createOrder($name, $orderDate, $surname, $telephone, $status, $orderOfferID, $orderUserID) {
        $sql = "INSERT INTO `order` (name, surname, telephone, status, orderOfferID, orderUserID) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$name, $surname, $telephone, $status, $orderOfferID, $orderUserID]);
        return $this->conn->lastInsertId(); // Возвращает ID только что созданного заказа
    }
    
    // Метод для обновления статуса заказа по его ID
    public function updateOrderStatus($orderID, $status) {
        $sql = "UPDATE `order` SET status = ? WHERE orderID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$status, $orderID]);
        return $stmt->rowCount(); // Возвращает количество обновленных строк
    }
}

?>