<?php
require_once 'connection.php';

class SearchOption extends Database{
    public function searchOffers($search, $column) {
      $query = "SELECT * FROM offers WHERE manufacturer LIKE :search OR type LIKE :search OR CONCAT(manufacturer, ' ', type) LIKE :search OR CONCAT(manufacturer, type) LIKE :search";
      $stmt = $this->connect()->prepare($query);
      $stmt->execute(['search' => '%'.$search.'%']);
      $result = $stmt->fetchAll();
      return $result;
    }
  }
  

?>