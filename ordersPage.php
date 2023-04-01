<?php
session_start();
require_once 'connection.php';
require_once 'Order.php';
require_once 'User.php';

$order = new Order(0, $_SESSION['userID']);
$orders = $order->getOrderInfo();

if (!empty($orders)) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Date</th><th>Name</th><th>Surname</th><th>Telephone</th><th>Status</th><th>Username</th><th>Email</th><th>Make</th><th>Model</th><th>Price</th></tr>";
    foreach ($orders as $order) {
        echo "<tr>";
        echo "<td>".$order['orderID']."</td>";
        echo "<td>".$order['orderDate']."</td>";
        echo "<td>".$order['name']."</td>";
        echo "<td>".$order['surname']."</td>";
        echo "<td>".$order['telephone']."</td>";
        echo "<td>".$order['status']."</td>";
        echo "<td>".$order['username']."</td>";
        echo "<td>".$order['email']."</td>";
        echo "<td>".$order['make']."</td>";
        echo "<td>".$order['model']."</td>";
        echo "<td>".$order['price']."</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No orders found.";
}

$user = new UserMain($_SESSION['userID']);
$userInfo = $user->getUserInfo();

echo "<h2>My Profile</h2>";
echo "<p>Username: ".$userInfo['username']."</p>";
echo "<p>Email: ".$userInfo['email']."</p>";
