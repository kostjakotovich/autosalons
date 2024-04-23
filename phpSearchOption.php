<?php
require_once 'connection.php';

class SearchOption extends Database
{
    public function searchOffers($search, $selectedBrand, $selectedModel, $selectedType, $selectedYear, $selectedColor, $selectedTransmission, $currentMinPrice, $currentMaxPrice)
    {
        $query = "SELECT offers.*, offersinfo.*, specific_details.*, car_colors.*, transmission.*
                FROM offers
                INNER JOIN offersinfo ON offersinfo.offersID = offers.offerID
                INNER JOIN specific_details ON offersinfo.offersInfoID = specific_details.offersInfoID
                INNER JOIN car_colors ON specific_details.colorID = car_colors.colorID  
                INNER JOIN transmission ON specific_details.transmissionID = transmission.transmissionID 
                WHERE (manufacturer LIKE :search OR type LIKE :search OR CONCAT(manufacturer, ' ', type) LIKE :search OR CONCAT(manufacturer, type) LIKE :search)";

        if (!empty($selectedBrand)) {
            $query .= " AND offers.manufacturer=:selectedBrand";
        }

        if (!empty($selectedModel)) {
            $query .= " AND offers.type=:selectedModel";
        }

        if (!empty($selectedType)) {
            $query .= " AND offersinfo.body_type=:selectedType";
        }

        if (!empty($selectedYear)) {
            $query .= " AND offersinfo.yearOfManufacture=:selectedYear";
        }

        if (!empty($selectedColor)) {
          $query .= " AND car_colors.color=:selectedColor";
        }

        if (!empty($selectedTransmission)) {
            // для поиска частичного совпадения
            $selectedTransmission = '%' . $selectedTransmission . '%';
            $query .= " AND transmission.transmission_type LIKE :selectedTransmission";
        }
        

        if (!empty($currentMinPrice)) {
            $query .= " AND (offersinfo.price + car_colors.color_price + transmission.transmission_price) >= :currentMinPrice";
        }

        if (!empty($currentMaxPrice)) {
            $query .= " AND (offersinfo.price + car_colors.color_price + transmission.transmission_price) <= :currentMaxPrice";
        }

        $stmt = $this->connect()->prepare($query);
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);

        if (!empty($selectedBrand)) {
          $stmt->bindValue(':selectedBrand', $selectedBrand, PDO::PARAM_STR);
        }

        if (!empty($selectedModel)) {
            $stmt->bindValue(':selectedModel', $selectedModel, PDO::PARAM_STR);
        }

        if (!empty($selectedType)) {
            $stmt->bindValue(':selectedType', $selectedType, PDO::PARAM_STR);
        }

        if (!empty($selectedYear)) {
            $stmt->bindValue(':selectedYear', $selectedYear, PDO::PARAM_STR);
        }

        if (!empty($selectedColor)) {
            $stmt->bindValue(':selectedColor', $selectedColor, PDO::PARAM_STR);
        }

        if (!empty($selectedTransmission)) {
            $stmt->bindValue(':selectedTransmission', $selectedTransmission, PDO::PARAM_STR);
        }

        if (!empty($currentMinPrice)) {
            $stmt->bindValue(':currentMinPrice', $currentMinPrice, PDO::PARAM_INT);
        }

        if (!empty($currentMaxPrice)) {
            $stmt->bindValue(':currentMaxPrice', $currentMaxPrice, PDO::PARAM_INT);
        }

        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
}
?>
