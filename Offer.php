<?php
require_once 'connection.php';

class Offer {
    
    private $conn;

    private $offerID;
    private $type;
    private $manufacturer;
    private $image;

    private $offersInfoID;
    private $color;
    private $price;
    private $yearOfManufacture;
    private $weight;
    
    public function __construct() {
        $this->conn = (new Database())->connect();
    }
    
    public function getOffer($offerID) {
        $sql = "SELECT * FROM offers WHERE offerID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$offerID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
    
    public function getOfferInfo($offerID) {
        $sql = "SELECT * FROM offersinfo WHERE offersID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$offerID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function getAllOffers() {
        $sql = "SELECT * FROM offers INNER JOIN offersinfo on offers.offerID = offersinfo.offersID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    
}

?>
