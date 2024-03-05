<?php
require_once 'connection.php';

class SearchOption extends Database
{
    public function searchOffers($search, $selectedBrand, $selectedType, $selectedColor, $currentMinPrice, $currentMaxPrice)
    {
        $query = "SELECT * 
                FROM offers 
                INNER JOIN car_colors ON offers.offerID = car_colors.offerID
                INNER JOIN offersinfo ON offers.offerID = offersinfo.offersID  
                WHERE (manufacturer LIKE :search OR type LIKE :search OR CONCAT(manufacturer, ' ', type) LIKE :search OR CONCAT(manufacturer, type) LIKE :search)";

        if (!empty($selectedBrand)) {
            $query .= " AND offers.manufacturer=:selectedBrand";
        }

        if (!empty($selectedType)) {
            $query .= " AND offersinfo.body_type=:selectedType";
        }

        if (!empty($selectedColor)) {
          $query .= " AND car_colors.color=:selectedColor";
        }

        if (!empty($currentMinPrice)) {
            $query .= " AND (offersinfo.price + car_colors.color_price) >= :currentMinPrice";
        }

        if (!empty($currentMaxPrice)) {
            $query .= " AND (offersinfo.price + car_colors.color_price) <= :currentMaxPrice";
        }

        $stmt = $this->connect()->prepare($query);
        $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);

        if (!empty($selectedBrand)) {
          $stmt->bindValue(':selectedBrand', $selectedBrand, PDO::PARAM_STR);
        }

        if (!empty($selectedType)) {
            $stmt->bindValue(':selectedType', $selectedType, PDO::PARAM_STR);
        }

        if (!empty($selectedColor)) {
            $stmt->bindValue(':selectedColor', $selectedColor, PDO::PARAM_STR);
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
