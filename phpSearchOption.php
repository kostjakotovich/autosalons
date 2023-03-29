<?php
require_once 'connection.php';

class SearchOption extends Database{
    private $search;
    private $column;
    private $result;
  
    public function __construct($search, $column){
        $this->search = $search;
        $this->column = $column;
    }
  
    public function searchComments(){
        $conn = $this->getDBConnection();
        $sql = "SELECT * FROM comments WHERE {$this->column} LIKE '%{$this->search}%'";
        $this->result = $conn->query($sql);
  
        if ($this->result !== false) {
            $num_rows = $this->result->rowCount();
  
            if ($num_rows > 0){
                while($row = $this->result->fetch(PDO::FETCH_ASSOC)){
                    echo $row["name"] . "  " . $row["email"] . "<br>";
                }
            } else {
                echo "0 records";
            }
        } else {
            echo "Error: " . $conn->error;
        }
  
        $this->result = null;
        $conn = null;
    }
  }  

$search = $_POST['search'];
$column = $_POST['column'];

$searchOption = new SearchOption($search, $column);
$searchOption->searchComments();
?>