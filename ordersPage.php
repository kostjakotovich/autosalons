<?php
session_start();
require_once 'connection.php';
require_once 'Order.php';
require_once 'User.php';

$order = new Order(0, $_SESSION['userID']);
$orders = $order->getAllOrderInfo();
?>

<html>
<head>
  <script src="../autosalons/js/script.js" defer></script>
  <script src="../autosalons/js/form-popup.js" defer></script>
  <link rel="stylesheet" href="css/orders.css">
</head>
<body>
    <?php require 'header.php';?>
    <table>
    <tr>
    <th>Order Nr</th>
    <th>Order Date</th>
    <th>Name</th>
    <th>Surname</th>
    <th>Telephone</th>
    <th>Status</th>
    <th>Username</th>
    <th>Email</th>
    <th>Manufacturer</th>
    <th>Model</th>
    <th>Price</th>
    </tr>
    <?php 
        foreach($orders as $order){
            echo "<tr>";
            echo "<td>".$order['orderID']."</td>";
            echo "<td>".$order['orderDate']."</td>";
            echo "<td>".$order['name']."</td>";
            echo "<td>".$order['surname']."</td>";
            echo "<td>".$order['telephone']."</td>";
            echo "<td>".$order['status']."</td>";
            echo "<td>".$order['username']."</td>";
            echo "<td>".$order['email']."</td>";
            echo "<td>".$order['manufacturer']."</td>";
            echo "<td>".$order['type']."</td>";
            echo "<td>".$order['price']." $</td>";
            echo "</tr>";
        }
    ?>
    </table>
<?php 
    $user = new UserMain($_SESSION['userID']);
    $userInfo = $user->getUserInfo();
    ?>
</body>