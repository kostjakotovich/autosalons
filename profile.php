<?php
session_start();
require_once 'connection.php';
require_once 'User.php';
require_once 'Order.php';

if(isset($_SESSION["userID"])) {
  $userID = $_SESSION["userID"];
  $user = new UserMain($userID);
  $userInfo = $user->getUserInfo();
  if(isset($userInfo)){
      $username = $userInfo['username'];
      $email = $userInfo['email'];
  }

  // обработка изменения пароля
  if(isset($_POST['changePassword'])) {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if($user->changePassword($currentPassword, $newPassword, $confirmPassword)) {
      // если пароль успешно изменен, перенаправляем пользователя на страницу профиля
      header('location: profile.php');
      exit();
    } else {
      // если произошла ошибка, сохраняем ее в переменной и выводим на страницу
      $error = "Unable to change password. Please check your current password and make sure the new password fields match.";
    }
  }


  // создаем экземпляр класса Order и передаем userID текущего пользователя
  $order = new Order(null, $userID);
  $orders = $order->getOrderInfo();
} else {
  header('location: loginPage.php');
}

?>

<html>
  <head>
    <?php require 'header.php'; ?>
    <script src="../autosalons/js/script.js" defer></script>
    <script src="../autosalons/js/toggle-tab.js" defer></script>
    <link rel="stylesheet" href="css/profile.css">

    <title>User Profile</title>
  </head>
  <body>

<div class="tab">
  <button class="tablinks active" onclick="openTab(event, 'UserInfo')">User Info</button>
  <button class="tablinks" onclick="openTab(event, 'Orders')">Orders</button>
</div>

<div id="UserInfo" class="tabcontent" style="display: block;">
  <p style="font-size: 20px;">Name: <?php echo $username; ?></p>
  <p style="font-size: 20px;">Email: <?php echo $email; ?></p>
  <button class="btn">Change Password</button>

  <div id="changePassword" style="display:none;">
  <form method="post">
    <label for="currentPassword">Current password:</label>
    <input type="password" id="currentPassword" name="currentPassword" required>
    <br>
    <label for="newPassword">New password:</label>
    <input type="password" id="newPassword" name="newPassword" required>
    <br>
    <label for="confirmPassword">Confirm new password:</label>
    <input type="password" id="confirmPassword" name="confirmPassword" required>
    <br>
    <input type="submit" name="changePassword" value="Change Password">
  </form>
</div>

</div>

<div id="Orders" class="tabcontent">
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
</div>

<script>
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }
    
    document.getElementsByClassName("tablinks")[0].click();
</script>

<script>
  var changePasswordBtn = document.querySelector('.btn');
  var changePasswordDiv = document.getElementById('changePassword');

  changePasswordBtn.addEventListener('click', function() {
    if (changePasswordDiv.style.display === 'none') {
      changePasswordDiv.style.display = 'block';
    } else {
      changePasswordDiv.style.display = 'none';
    }
  });

</script>
