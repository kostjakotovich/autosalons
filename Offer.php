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

    public function getOfferColor($offerID) {
        $sql = "SELECT * FROM car_colors WHERE offerID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$offerID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getOfferColors($offerID) {
        $sql = "SELECT color, color_price FROM car_colors WHERE offerID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$offerID]);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }    

    public function getOfferColorByColor($offerID, $color) {
        $sql = "SELECT * FROM car_colors WHERE offerID = ? AND color = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$offerID, $color]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function getAllOffers() {
        $sql = "SELECT * FROM offers INNER JOIN offersinfo on offers.offerID = offersinfo.offersID INNER JOIN car_colors on offers.offerID = car_colors.offerID";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    
    public function deleteColor($offerID, $color) {
        $sql = "DELETE FROM car_colors WHERE offerID = ? AND color = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$offerID, $color]);
    }
    
    public function addColor($offerID, $color, $colorPrice, $imageFilePath) {
        $sql = "INSERT INTO car_colors (offerID, color, color_price, image) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$offerID, $color, $colorPrice, $imageFilePath]);
    }       

    public function getColorPrice($offerID, $color) {
        $sql = "SELECT color_price FROM car_colors WHERE offerID = ? AND color = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$offerID, $color]);
        $result = $stmt->fetchColumn();
        return $result;
    }

    public function addOffer($data) {
        $imageFileName = $_FILES['image']['name'];
        $imageFilePath = '../autosalons/img/' . $imageFileName;
        move_uploaded_file($_FILES['image']['tmp_name'], $imageFilePath);
    
        $this->conn->beginTransaction();
    
        try {
            // Сначала добавляем информацию о предложении в таблицу offers
            $sql = "INSERT INTO offers (type, manufacturer) VALUES (?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$data['type'], $data['manufacturer']]);
    
            $offerID = $this->conn->lastInsertId();
    
            // Затем добавляем информацию о цвете и URL изображения в таблицу car_colors
            $sql = "INSERT INTO car_colors (offerID, color, image, color_price) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$offerID, $data['color'], $imageFilePath, $data['color_price']]);
    
            // Наконец, добавляем остальную информацию о предложении в таблицу offersinfo
            $sql = "INSERT INTO offersinfo (offersID, price, yearOfManufacture, weight) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$offerID, $data['price'], $data['yearOfManufacture'], $data['weight']]);
    
            $this->conn->commit();
    
            $_SESSION['offer_add_success'] = "Offer added successfully.";
        } catch (PDOException $e) {
            $this->conn->rollback();
            echo "Error: " . $e->getMessage();
        }
    }
    
    public function updateOfferInformation($offerID, $type, $manufacturer, $color, $color_price, $price, $weight, $yearOfManufacture, $imageFilePath) {
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
        if (!empty($color)) {
            $setValues[] = 'car_colors.color = ?';
            $params[] = $color;
        }
        if (!empty($color_price)) {
            $setValues[] = 'car_colors.color_price = ?';
            $params[] = $color_price;
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
            $setValues[] = 'car_colors.image = ?';
            $params[] = $imageFilePath;
        }
    
        // Формируем SET часть запроса
        $setPart = implode(', ', $setValues);
    
        // Добавляем в параметры ID предложения для условия WHERE
        $params[] = $offerID;
    
        // Формируем SQL-запрос
        $sql = "UPDATE offers 
                INNER JOIN offersinfo ON offers.offerID = offersinfo.offersID 
                INNER JOIN car_colors ON offers.offerID = car_colors.offerID 
                SET $setPart
                WHERE offers.offerID = ?";
    
        // Подготавливаем и выполняем запрос
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
    
        // Возвращаем результат выполнения запроса
        return $stmt->rowCount() > 0;
    }
    
    
}
?>
