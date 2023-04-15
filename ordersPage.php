<?php
session_start();
require_once 'connection.php';
require_once 'Order.php';
require_once 'User.php';

// Создаем объект пользователя, чтобы получить информацию о роли
$user = new UserMain($_SESSION['userID']);
$userInfo = $user->getUserInfo();

// Проверяем, является ли пользователь администратором
if ($_SESSION['roleID'] !== 1) {
    // Если нет, то перенаправляем на главную страницу
    header('Location: index.php');
    exit();
}

// Создаем объект заказа
$order = new Order(0, 0); // второй параметр - userID - не важен, т.к. будет устанавливаться внутри цикла

// Получаем информацию о всех заказах
$orders = $order->getAllOrderInfo();

if (isset($_POST['submit'])) {
    foreach ($_POST['status'] as $orderID => $status) {
        // Обновляем статус заказа по его ID
        $order = new Order($orderID, 0); // userID тоже не важен, т.к. обновлять статус может админ
        $order->updateStatus($status);

        // Перезагружаем информацию о заказах из базы данных
        $orders = $order->getAllOrderInfo();
    }
}


?>

<html>
<head>
  <script src="../autosalons/js/script.js" defer></script>
  <script src="../autosalons/js/form-popup.js" defer></script>
  <link rel="stylesheet" href="css/orders.css">
</head>
<body>
    <?php require 'header.php';?>
    <form method="post">
        <table>
        <thead>
        <tr>
        <th>Order Nr</th>
        <th>Order Date</th>
        <th>Name</th>
        <th>Surname</th>
        <th>Telephone</th>
        <th>Username</th>
        <th>Email</th>
        <th>Manufacturer</th>
        <th>Model</th>
        <th>Price</th>
        <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <?php 
            foreach($orders as $order){
                echo "<tr>";
                echo "<td>".$order['orderID']."</td>";
                echo "<td>".$order['orderDate']."</td>";
                echo "<td>".$order['name']."</td>";
                echo "<td>".$order['surname']."</td>";
                echo "<td>".$order['telephone']."</td>";    
                echo "<td>".$order['username']."</td>";
                echo "<td>".$order['email']."</td>";
                echo "<td>".$order['manufacturer']."</td>";
                echo "<td>".$order['type']."</td>";
                echo "<td>".$order['price']." $</td>";
                echo "<td>
                <select name='status[$order[orderID]]'>
                    <option value='New'" . ($order['status'] == 'New' ? ' selected' : '') . ">New</option>
                    <option value='In progress'" . ($order['status'] == 'In progress' ? ' selected' : '') . ">In progress</option>
                    <option value='Done'" . ($order['status'] == 'Done' ? ' selected' : '') . ">Done</option>
                </select>
            
                      </td>";
                echo "</tr>";
            }
        ?>
        </tbody>
        </table>
        <input type="submit" name="submit" value="Update Status">
    </form>
    <?php 
        $user = new UserMain($_SESSION['userID']);
        $userInfo = $user->getUserInfo();
    ?>
</body>
</html>
