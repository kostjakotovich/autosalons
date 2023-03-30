<?php

require_once 'connection.php';

class Offer {
    
    private $conn;
    
    public function __construct() {
        $this->conn = (new Database())->connect();
    }
    
    public function getOffers() {
        $sql = "SELECT * FROM offers";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function getOfferInfo($offerID) {
        $sql = "SELECT * FROM offersinfo WHERE offersID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$offerID]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
}
