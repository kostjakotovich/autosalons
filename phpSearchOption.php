<?php
require_once 'connection.php';

class SearchOption extends Database{
  public function searchOffers($search, $selectedBrand, $currentPrice) {
      $query = "SELECT * 
                FROM offers 
                Inner join offersinfo on offers.offerID = offersinfo.offersID 
                WHERE (manufacturer LIKE :search OR type LIKE :search OR CONCAT(manufacturer, ' ', type) LIKE :search OR CONCAT(manufacturer, type) LIKE :search)";
      if (!empty($selectedBrand)) {
          $query .= " AND offers.manufacturer=:selectedBrand";
      }
      if (!empty($currentPrice)) {
          $query .= " AND offersinfo.price<=:currentPrice";
      }
      $stmt = $this->connect()->prepare($query);
      $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
      if (!empty($selectedBrand)) {
        $stmt->bindValue(':selectedBrand', $selectedBrand, PDO::PARAM_STR);
      }
      if (!empty($currentPrice)) {
          $stmt->bindValue(':currentPrice', $currentPrice, PDO::PARAM_INT);
      }
      $stmt->execute();
      $result = $stmt->fetchAll();
      return $result;
  }
}