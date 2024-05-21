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
        $sql = "SELECT * FROM offers 
                JOIN offersinfo ON offers.offerID = offersinfo.offersID
                JOIN specific_details ON offersinfo.offersInfoID = specific_details.offersInfoID
                JOIN car_colors ON specific_details.colorID = car_colors.colorID
                JOIN transmission ON specific_details.transmissionID = transmission.transmissionID
                JOIN engine ON specific_details.engineID = engine.engineID
                WHERE offerID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$offerID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result; 
    }
    
    public function getOffersInfoID($offerID) {
        $sql = "SELECT offersInfoID FROM offersinfo WHERE offersID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$offerID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $result['offersInfoID'];
        } else {
            return null;
        }
    }    
    
    public function getOfferInfo($offersInfoID) {
        $sql = "SELECT * FROM offersinfo WHERE offersID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$offersInfoID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getOfferTransmission($offersInfoID, $detailsID) {
        $sql = "SELECT * FROM transmission 
                INNER JOIN specific_details ON specific_details.transmissionID = transmission.transmissionID
                INNER JOIN offersinfo ON specific_details.offersInfoID = offersinfo.offersInfoID
                WHERE offersinfo.offersInfoID = ? AND specific_details.detailsID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$offersInfoID, $detailsID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getOfferEngine($offersInfoID, $detailsID) {
        $sql = "SELECT * FROM engine
                INNER JOIN specific_details ON specific_details.engineID = engine.engineID
                INNER JOIN offersinfo ON specific_details.offersInfoID = offersinfo.offersInfoID
                WHERE offersinfo.offersInfoID = ? AND specific_details.detailsID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$offersInfoID, $detailsID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getOfferColor($offersInfoID, $detailsID) {
        $sql = "SELECT * FROM car_colors 
                INNER JOIN specific_details ON specific_details.colorID = car_colors.colorID
                INNER JOIN offersinfo ON specific_details.offersInfoID = offersinfo.offersInfoID
                WHERE offersinfo.offersInfoID = ? AND specific_details.detailsID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$offersInfoID, $detailsID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getOfferDetails($offersInfoID) {
        $sql = "SELECT car_colors.*, specific_details.*, transmission.*, offersinfo.*, engine.*
                FROM specific_details
                INNER JOIN car_colors ON specific_details.colorID = car_colors.colorID
                INNER JOIN transmission ON specific_details.transmissionID = transmission.transmissionID
                INNER JOIN engine ON specific_details.engineID = engine.engineID
                INNER JOIN offersinfo on offersinfo.offersInfoID = specific_details.offersInfoID
                WHERE specific_details.offersInfoID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$offersInfoID]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }     

    public function getOfferDetailsByID($offersInfoID) {
        $sql = "SELECT specific_details.*, car_colors.*, transmission.*, offersinfo.*, engine.*
                FROM specific_details
                INNER JOIN car_colors ON specific_details.colorID = car_colors.colorID
                INNER JOIN transmission ON specific_details.transmissionID = transmission.transmissionID
                INNER JOIN engine ON specific_details.engineID = engine.engineID
                INNER JOIN offersinfo on offersinfo.offersInfoID = specific_details.offersInfoID
                WHERE offersinfo.offersInfoID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$offersInfoID]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
      
    
    public function getAllOffers() {
        $sql = "SELECT offers.*, offersinfo.*, specific_details.*, car_colors.*, transmission.*, engine.*
                FROM offers
                JOIN offersinfo ON offers.offerID = offersinfo.offersID
                JOIN specific_details ON offersinfo.offersInfoID = specific_details.offersInfoID
                JOIN car_colors ON specific_details.colorID = car_colors.colorID
                JOIN transmission ON specific_details.transmissionID = transmission.transmissionID
                JOIN engine ON specific_details.engineID = engine.engineID
                ORDER BY manufacturer, type";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }    

    public function addOffer($data) {
        $imageFileName = $_FILES['image']['name'];
        $imageFilePath = 'img/' . $imageFileName;
        move_uploaded_file($_FILES['image']['tmp_name'], $imageFilePath);
    
        $this->conn->beginTransaction();
    
        try {
            $sql = "INSERT INTO offers (type, manufacturer) VALUES (?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$data['type'], $data['manufacturer']]);
            $offerID = $this->conn->lastInsertId();
    
            $sql = "INSERT INTO car_colors (color, image, color_price) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$data['color'], $imageFilePath, $data['color_price']]);
            $colorID = $this->conn->lastInsertId();

            $sql = "INSERT INTO transmission (transmission_type, transmission_price) VALUES (?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$data['transmission_type'], $data['transmission_price']]);
            $transmissionID = $this->conn->lastInsertId();

            $sql = "INSERT INTO engine (engine_type, engine_price) VALUES (?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$data['engine_type'], $data['engine_price']]);
            $engineID = $this->conn->lastInsertId();
    
            $sql = "INSERT INTO offersinfo (offersID, price, yearOfManufacture, weight, body_type) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$offerID, $data['price'], $data['yearOfManufacture'], $data['weight'], $data['body_type']]);
            $offersInfoID = $this->conn->lastInsertId();
    
            $sql = "INSERT INTO specific_details (offersInfoID, colorID, transmissionID, created_at, engineID) VALUES (?, ?, ?, NOW(), ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$offersInfoID, $colorID, $transmissionID, $engineID]);
    
            $this->conn->commit();
    
            $_SESSION['offer_add_success'] = "Offer added successfully.";
        } catch (PDOException $e) {
            $this->conn->rollback();
            echo "Error: " . $e->getMessage();
        }
    }         
    
    public function updateOfferInformation($offerID, $detailsID, $type, $manufacturer, $body_type, $transmission_type, $transmission_price, $engine_type, $engine_price, $color, $color_price, $price, $weight, $yearOfManufacture, $imageFilePath) {
        $this->conn->beginTransaction();
    
        try {
    
            $setValues = [];
    
            $params = [];
    
            // Добавляем значения для SET части запроса и их параметры в массивы, если они были переданы
            if (isset($type)) {
                $setValues[] = 'offers.type = ?';
                $params[] = $type;
            }
            if (isset($manufacturer)) {
                $setValues[] = 'offers.manufacturer = ?';
                $params[] = $manufacturer;
            }
            if (isset($body_type)) {
                $setValues[] = 'offersinfo.body_type = ?';
                $params[] = $body_type;
            }
            if (isset($transmission_type)) {
                $setValues[] = 'transmission.transmission_type = ?';
                $params[] = $transmission_type;
            }
            if (isset($transmission_price) || $transmission_price === '0') {
                $setValues[] = 'transmission.transmission_price = ?';
                $params[] = $transmission_price;
            }
            if (isset($engine_type)) {
                $setValues[] = 'engine.engine_type = ?';
                $params[] = $engine_type;
            }
            if (isset($engine_price) || $engine_price === '0') {
                $setValues[] = 'engine.engine_price = ?';
                $params[] = $engine_price;
            }
            if (isset($color)) {
                $setValues[] = 'car_colors.color = ?';
                $params[] = $color;
            }
            if (isset($color_price) || $color_price === '0') {
                $setValues[] = 'car_colors.color_price = ?';
                $params[] = $color_price;
            }
            if (isset($price) || $price === '0') {
                $setValues[] = 'offersinfo.price = ?';
                $params[] = $price;
            }
            if (isset($weight) || $weight === '0') {
                $setValues[] = 'offersinfo.weight = ?';
                $params[] = $weight;
            }
            if (isset($yearOfManufacture)) {
                $setValues[] = 'offersinfo.yearOfManufacture = ?';
                $params[] = $yearOfManufacture;
            }
            if (!empty($imageFilePath)) {
                $setValues[] = 'car_colors.image = ?';
                $params[] = $imageFilePath;
            }         
    
            $setPart = implode(', ', $setValues);
    
            $params[] = $offerID;
            $params[] = $detailsID;
    
            $sql = "UPDATE offers 
                    INNER JOIN offersinfo ON offers.offerID = offersinfo.offersID 
                    INNER JOIN specific_details ON offersinfo.offersInfoID = specific_details.offersInfoID 
                    INNER JOIN car_colors ON specific_details.colorID = car_colors.colorID 
                    INNER JOIN transmission ON specific_details.transmissionID = transmission.transmissionID 
                    INNER JOIN engine ON specific_details.engineID = engine.engineID 
                    SET $setPart
                    WHERE offers.offerID = ? AND specific_details.detailsID = ?";
   
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
    
            $this->conn->commit();
    
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            $this->conn->rollback();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }    

    public function addConfiguration($detailsID, $offersInfoID, $color, $image, $color_price, $transmission_type, $transmission_price, $engine_type, $engine_price) {
        // Вставка записи в таблицу car_colors
        $sql = "INSERT INTO car_colors (color, image, color_price) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$color, $image, $color_price]);
        $colorID = $this->conn->lastInsertId();
    
        // Вставка записи в таблицу transmission
        $sql = "INSERT INTO transmission (transmission_type, transmission_price) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$transmission_type, $transmission_price]);
        $transmissionID = $this->conn->lastInsertId();
    
        // Вставка записи в таблицу engine
        $sql = "INSERT INTO engine (engine_type, engine_price) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$engine_type, $engine_price]);
        $engineID = $this->conn->lastInsertId();
    
        // Вставка записи в таблицу specific_details
        $sql = "INSERT INTO specific_details (offersInfoID, colorID, transmissionID, created_at, engineID) 
                VALUES (?, ?, ?, NOW(), ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$offersInfoID, $colorID, $transmissionID, $engineID]);
    
        return true;
    }   

    public function checkOrderConnection($detailsID) {
        $sql = "SELECT COUNT(*) AS totalOrders FROM `order` WHERE orderDetailsID = :detailsID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':detailsID', $detailsID, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['totalOrders'];
    }
    
    public function deleteConfiguration($detailsID) {
        try {

            $totalOrders = $this->checkOrderConnection($detailsID);

            if ($totalOrders == 0) {
                $sql = "SELECT colorID, transmissionID, engineID FROM specific_details WHERE detailsID = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$detailsID]);
                $configInfo = $stmt->fetch(PDO::FETCH_ASSOC);
                
                $sql = "DELETE FROM specific_details WHERE detailsID = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$detailsID]);
                
                $sql = "DELETE FROM car_colors WHERE colorID = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$configInfo['colorID']]);
                
                $sql = "DELETE FROM transmission WHERE transmissionID = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$configInfo['transmissionID']]);
                
                $sql = "DELETE FROM engine WHERE engineID = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$configInfo['engineID']]);
                
                header("Location: index.php");
                exit();
            
                return true; 
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; // В случае ошибки возвращаем false
        }
    }

    public function deactivateOffer($detailsID) {
        $sql = "UPDATE specific_details SET active_status = 1 WHERE detailsID = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$detailsID]);
    }    

    public function activateOffer($detailsID) {
        $sql = "UPDATE specific_details SET active_status = 0 WHERE detailsID = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$detailsID]);
    }    

    public function isOfferActive($detailsID) {
        $sql = "SELECT active_status FROM specific_details WHERE detailsID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$detailsID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['active_status'] ?? false;
    }    
    
}
?>
