<?php
session_start();
require_once 'connection.php';
require_once 'User.php';
require_once 'Order.php';

// проверка наличия ошибок
if(isset($_SESSION["userID"])) {
  $userID = $_SESSION["userID"];
  $user = new UserMain($userID);
  $userInfo = $user->getUserInfo();
  if(isset($userInfo)){
      $username = $userInfo['username'];
      $email = $userInfo['email'];
  }
} else {
  header('location: loginPage.php');
}
// обработка изменения пароля
$change_errors = array();
// обработка изменения пароля
if (isset($_POST["changePassword"])) {
  $change_errors = array();

  $user = new UserMain($userID);
  $userPassword = $user->getPassword();

  $currentPassword = $_POST["currentPassword"];
  $newPassword = $_POST["newPassword"];
  $confirmPassword = $_POST["confirmPassword"];
  // проверка, что пароль в первом поле совпадает с текущим паролем пользователя
  if (!password_verify($currentPassword, $userPassword)) {
      array_push($change_errors,"Current password is incorrect.");
  } // проверка, что новый пароль во втором поле не совпадает с текущим паролем пользователя
  if (password_verify($newPassword, $userPassword)) {
      array_push($change_errors,"New password must not be the same as current password.");
  }

  // проверка, что пароли во втором и третьем полях совпадают
  if ($newPassword !== $confirmPassword) {
      array_push($change_errors,"New password and confirmation password do not match.");
  }
  if (count($change_errors) == 0) {
      // изменение пароля
      if ($user->changePassword($currentPassword, $newPassword, $confirmPassword)) {
        // если пароль успешно изменен, перенаправляем пользователя на страницу профиля
        $_SESSION['success_change'] = 'Password change successful';
        session_write_close(); // сохранение данных сессии
        header('location: profile.php');
      } else {
          // если произошла ошибка, сохраняем ее в переменной и выводим на страницу
          array_push($change_errors,"Unable to change password. Please check your current password and make sure the new password fields match.");
      }
    
  }
}

// создаем экземпляр класса Order и передаем userID текущего пользователя
$order = new Order();
$orders = $order->getOrderInfo($userID);
$totalSum = $order -> getOrderSum($userID);

if (isset($_POST["updateAvatar"])) {
  $uploadDir = 'img/avatar';
  $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);

  if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile)) {
      // Загрузка успешно выполнена, обновляем аватарку в базе данных
      $user->updatePicture($uploadFile);
      // Перенаправляем пользователя на страницу профиля
      header('Location: profile.php');
      exit;
  } else {
      // Произошла ошибка при загрузке
      echo "Error uploading file.";
  }
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
  <button class="tablinks" onclick="openTab(event, 'Orders')">My Orders</button>
</div>

<div id="UserInfo" class="tabcontent" style="display: block;">
  <div class="user-card">
    <div class="user-info">
      <UserInfo>
        <!-- Отображение текущей аватарки -->
        <img src="<?php echo $user->getPicture(); ?>" alt="User Avatar" width="200" height="200">
        <div style="float:right;">
          <!-- Форма для изменения аватарки --> 
          <form method="post" enctype="multipart/form-data" class="avatar-form">
              <label for="avatar" class="avatar-label">Choose a new avatar:</label><br>
              <input type="file" id="avatar" name="avatar" class="avatar-input">
              <button type="submit" name="updateAvatar" class="avatar-button">Upload Avatar</button>
          </form>
        </div>

        <div style="margin-top:10%;">
          <div class="user-name"><?php echo $username; ?></div>
          <div class="user-email"><?php echo $email; ?></div>
        </div>
      </UserInfo>
    </div>
    <?php  
    if ($_SESSION['roleID'] == 1) { 
      echo "<br><br><br><strong style='font-size: 20px;'>Contact your administrator for help changing your password.</strong>";
    } ?>
  </div>
    <?php if ($_SESSION['roleID'] == 0) { ?>
      <button class="btn" class="btn change-password-btn">Change Password</button>

      <div id="changePassword" style="display:none;">
        <div id="form-group">
          <form method="post">
            <br>
            <label for="currentPassword">Current password:</label>
            <input type="password" id="currentPassword" class="form-control" name="currentPassword" required>
            <br>
            <label for="newPassword">New password:</label>
            <input type="password" id="newPassword" class="form-control" name="newPassword" required>
            <br>
            <label for="confirmPassword">Confirm new password:</label>
            <input type="password" id="confirmPassword" class="form-control" name="confirmPassword" required>
            <br>
            <input type="submit" name="changePassword" class="form-control" value="Change Password" >
          </form>
          
        </div>
        <?php if (isset($_SESSION['success_change'])): ?>
      <div class="alert alert-success" style="text-align: center;"><?php echo $_SESSION['success_change']; ?></div>
      <?php unset($_SESSION['success_change']); ?>
    <?php endif; ?>


    <?php if (!empty($change_errors)): ?>
        <div class="alert alert-danger" role="alert">
          <ul>
            <?php foreach ($change_errors as $error): ?>
              <p><?php echo $error; ?></p>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>
      </div>
    <?php } ?>
    </div>
</div>

<div id="Orders" class="tabcontent">
  <div style="float:right; width: 200px;">
      <!-- Кнопка для экспорта в Excel -->
    <form method="post" action="includes/exportUserOrders.inc.php">
      <input type="hidden" name="userID" value="<?php echo $userID; ?>">
      <input type="hidden" name="totalSum" value="<?php echo $totalSum; ?>">
      <input type="submit" name="export" value="Export to Excel" class="btn">
    </form>
  </div>

  <?php
    if($totalSum){
      echo"<strong>Total price: $totalSum$</strong>";
    }
    else {
      echo"<strong>Total price: 0$</strong>";
    }
  ?>

  <table>
    <?php include 'includes/userOrdersTable.php'; ?>
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
            echo "<td>".$order['color']."</td>";
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

</body>