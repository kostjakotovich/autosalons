<?php
require_once 'connection.php';
$search = $_POST['search'];
$column = $_POST['column'];


if ($conn->connect_error){
	die("Connection failed: ". $conn->connect_error);
}

$sql = "select * from comments where $column like '%$search%'";

$result = $conn->query($sql);

if ($result->num_rows > 0){
while($row = $result->fetch_assoc() ){
	echo $row["name"]."  ".$row["email"]."<br>";
}
} else {
	echo "0 records";
}

$conn->close();

?>