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

    public function getOfferTransmission($offersInfoID) {
        $sql = "SELECT * FROM transmission 
                INNER JOIN specific_details ON specific_details.transmissionID = transmission.transmissionID
                WHERE offersInfoID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$offersInfoID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getOfferColor($offersInfoID) {
        $sql = "SELECT * FROM car_colors 
                INNER JOIN specific_details ON specific_details.colorID = car_colors.colorID
                WHERE offersInfoID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$offersInfoID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getOfferDetails($offersInfoID) {
        $sql = "SELECT car_colors.*, specific_details.*, transmission.*, offersinfo.*
                FROM specific_details
                INNER JOIN car_colors ON specific_details.colorID = car_colors.colorID
                INNER JOIN transmission ON specific_details.transmissionID = transmission.transmissionID
                INNER JOIN offersinfo on offersinfo.offersInfoID = specific_details.offersInfoID
                WHERE specific_details.offersInfoID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$offersInfoID]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }     

    public function getOfferDetailsByID($detailsID) {
        $sql = "SELECT specific_details.*, car_colors.*, transmission.*, offersinfo.*
                FROM specific_details
                INNER JOIN car_colors ON specific_details.colorID = car_colors.colorID
                INNER JOIN transmission ON specific_details.transmissionID = transmission.transmissionID
                INNER JOIN offersinfo on offersinfo.offersInfoID = specific_details.offersInfoID
                WHERE specific_details.detailsID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$detailsID]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
      
    
    public function getAllOffers() {
        $sql = "SELECT offers.*, offersinfo.*, specific_details.*, car_colors.*, transmission.*
                FROM offers
                JOIN offersinfo ON offers.offerID = offersinfo.offersID
                JOIN specific_details ON offersinfo.offersInfoID = specific_details.offersInfoID
                JOIN car_colors ON specific_details.colorID = car_colors.colorID
                JOIN transmission ON specific_details.transmissionID = transmission.transmissionID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }    
    
    public function deleteColor($offerID, $colorID) {
        $sql = "DELETE FROM specific_details WHERE offerID = ? AND colorID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$offerID, $colorID]);
    }    
    
    public function addColor($offerID, $color, $colorPrice, $imageFilePath) {
        $sql = "SELECT colorID FROM car_colors WHERE color = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$color]);
        $colorID = $stmt->fetchColumn();
    
        if (!$colorID) {
            $sql = "INSERT INTO car_colors (color, color_price, image) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$color, $colorPrice, $imageFilePath]);
            $colorID = $this->conn->lastInsertId();
        }
    
        $sql = "INSERT INTO specific_details (offerID, colorID) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$offerID, $colorID]);
    }
    
    public function getColorIDByName($color) {
        $sql = "SELECT colorID FROM car_colors WHERE color = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$color]);
        $colorID = $stmt->fetchColumn();
        return $colorID;
    }    

    public function addOffer($data) {
        $imageFileName = $_FILES['image']['name'];
        $imageFilePath = '../autosalons/img/' . $imageFileName;
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
    
            $sql = "INSERT INTO offersinfo (offersID, price, yearOfManufacture, weight, body_type) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$offerID, $data['price'], $data['yearOfManufacture'], $data['weight'], $data['body_type']]);
            $offersInfoID = $this->conn->lastInsertId();
    
            $sql = "INSERT INTO specific_details (offersInfoID, colorID, transmissionID, created_at) VALUES (?, ?, ?, NOW())";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$offersInfoID, $colorID, $transmissionID]);
    
            $this->conn->commit();
    
            $_SESSION['offer_add_success'] = "Offer added successfully.";
        } catch (PDOException $e) {
            $this->conn->rollback();
            echo "Error: " . $e->getMessage();
        }
    }         
    
    public function updateOfferInformation($offerID, $type, $manufacturer, $color, $color_price, $price, $weight, $yearOfManufacture, $imageFilePath) {
        $this->conn->beginTransaction();
    
        try {
            // Если указан новый цвет, проверяем его наличие в таблице car_colors
            $colorID = null;
            if (!empty($color)) {
                $colorID = $this->getColorIDByName($color);
                // Если цвет отсутствует, добавляем его в таблицу car_colors
                if (!$colorID) {
                    $this->addColor($color, $color_price, $imageFilePath);
                    $colorID = $this->conn->lastInsertId();
                }
            }
    
            // Создаем пустой массив для хранения значений для SET части запроса
            $setValues = [];
    
            // Создаем пустой массив для хранения значений для параметров запроса
            $params = [];
    
            // Добавляем значения для SET части запроса и их параметры в массивы, если они были переданы
            if (!empty($type)) {
                $setValues[] = 'offers.type = ?';
                $params[] = $type;
            }
            if (!empty($manufacturer)) {
                $setValues[] = 'offers.manufacturer = ?';
                $params[] = $manufacturer;
            }
            if (!empty($colorID)) {
                $setValues[] = 'specific_details.colorID = ?';
                $params[] = $colorID;
            }
            if (!empty($price)) {
                $setValues[] = 'offersinfo.price = ?';
                $params[] = $price;
            }
            if (!empty($weight)) {
                $setValues[] = 'offersinfo.weight = ?';
                $params[] = $weight;
            }
            if (!empty($yearOfManufacture)) {
                $setValues[] = 'offersinfo.yearOfManufacture = ?';
                $params[] = $yearOfManufacture;
            }
            if (!empty($imageFilePath)) {
                $setValues[] = 'specific_details.image = ?';
                $params[] = $imageFilePath;
            }
    
            // Формируем SET часть запроса
            $setPart = implode(', ', $setValues);
    
            // Добавляем в параметры ID предложения для условия WHERE
            $params[] = $offerID;
    
            // Формируем SQL-запрос
            $sql = "UPDATE offers 
                    INNER JOIN offersinfo ON offers.offerID = offersinfo.offersID 
                    INNER JOIN specific_details ON offers.offerID = specific_details.offerID 
                    SET $setPart
                    WHERE offers.offerID = ?";
    
            // Подготавливаем и выполняем запрос
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
    
}
?>
