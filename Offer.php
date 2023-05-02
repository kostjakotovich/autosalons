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
    

    public function addOffer($data) {
        $imageFileName = $_FILES['image']['name'];
        $imageFilePath = '../autosalons/img/' . $imageFileName;
        move_uploaded_file($_FILES['image']['tmp_name'], $imageFilePath);
    
        $this->conn->beginTransaction();
    
        try {
            $sql = "INSERT INTO offers (type, manufacturer, image) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$data['type'], $data['manufacturer'], $imageFilePath]);
    
            $offerID = $this->conn->lastInsertId();
    
            $sql = "INSERT INTO offersinfo (offersID, color, price, yearOfManufacture, weight) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$offerID, $data['color'], $data['price'], $data['yearOfManufacture'], $data['weight']]);
    
            $this->conn->commit();
    
            $_SESSION['offer_add_success'] = "Offer added successfully.";
        } catch (PDOException $e) {
            $this->conn->rollback();
            echo "Error: " . $e->getMessage();
        }
    }
    
    
    
    
}
?>
