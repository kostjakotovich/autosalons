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

if (isset($_FILES["avatar"])) {
  $uploadDir = 'img/avatar/';
  $uploadFile = $uploadDir . basename($_FILES['avatar']['name']);

  if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile)) {
      // Загрузка успешно выполнена, обновляем аватарку в базе данных
      $user->updatePicture($uploadFile);
      // Перенаправляем пользователя на страницу профиля
      header('Location: profile.php');
      exit;
  } else {
      header('Location: profile.php');
  }
}



?>

<html>
  <head>
    <?php require 'header.php'; ?>
    <script src="../autosalons/js/script.js" defer></script>
    <script src="../autosalons/js/toggle-tab.js" defer></script>
    <link rel="stylesheet" href="css/profile.css">

    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    
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
      
        <div class="container emp-profile" style="width: 100%; height: 100%; min-height: 500px;">
                    
                        <div class="row">
                            <div class="col-md-4">
                                <div class="profile-img">
                                    <img src="<?php echo $user->getPicture(); ?>" alt="User Avatar"/>
                                </div>
                            </div>  
                            <div class="col-md-6">
                                <div class="profile-head">
                                            <h5>
                                              <?php echo $username; ?>
                                            </h5>
                                            <h6>
                                            <?php if ($_SESSION['roleID'] == 1) { ?>
                                              Staff Worker
                                            <?php } 
                                            else {?>
                                              User
                                            <?php } ?>
                                            </h6>
                                            <p class="proile-rating"></p>
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true">About</a>
                                        </li>
                                    </ul>
                                </div>  
                            </div>
                            <!-- <div class="col-md-2">
                                <input type="submit" class="profile-edit-btn" name="btnAddMore" value="Edit Profile"/>
                            </div> -->
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                              <br>
                              <form method="post" enctype="multipart/form-data" id="avatarForm">
                                  <label for="avatar" class="custom-file-upload">
                                      <input type="file" id="avatar" name="avatar">
                                      Choose
                                  </label>
                              </form>
                            </div>
                            <div class="col-md-8">
                              <div class="tab-content profile-tab" id="myTabContent">
                                  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                      <div class="row">
                                          <div class="col-md-6">
                                              <label>User Name</label>
                                          </div>
                                          <div class="col-md-6">
                                              <p><?php echo $username; ?></p>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-md-6">
                                              <label>E-mail</label>
                                          </div>
                                          <div class="col-md-6">
                                              <p><?php echo $email; ?></p>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-md-6">
                                              <label>Permissions:</label>
                                          </div>
                                          <div class="col-md-6">
                                              <?php if ($_SESSION['roleID'] == 1) { ?>
                                                  <p>Staff</p>
                                              <?php } else { ?>
                                                  <p>Verified User</p>
                                              <?php } ?>
                                          </div>
                                      </div>
                                  </div>
                                  <?php if ($_SESSION['roleID'] == 0) { ?>
                                      <button class="btn change-password-btn">Change Password</button>

                                      <div id="changePassword" style="display:none;">
                                          <div>
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
                                                  <input type="submit" name="changePassword" class="form-control" value="Change Password">
                                              </form>
                                          </div>
                                      </div>

                                      <?php if (isset($_SESSION['success_change'])): ?>
                                          <div class="alert alert-success" style="color:black;"><?php echo $_SESSION['success_change']; ?></div>
                                          <?php unset($_SESSION['success_change']); ?>
                                      <?php endif; ?>

                                      <?php if (!empty($change_errors)): ?>
                                          <div class="alert alert-danger" role="alert">
                                              <ul>
                                                  <?php foreach ($change_errors as $error): ?>
                                                      <p style="color:black;"><?php echo $error; ?></p>
                                                  <?php endforeach; ?>
                                              </ul>
                                          </div>
                                      <?php endif; ?>
                                  </div>
                                <?php } else { ?>
                                  <br>
                                  <p>To change your password, contact your administrator.</p>
                                <?php } ?>
                                </div>
                            </div>
                        </div>  
                      </div>            
                </div> 
      </UserInfo>
    </div>
</div>

<div id="Orders" class="tabcontent">
  <div class="export-container">
      <!-- Кнопка для экспорта в Excel -->
    <form method="post" action="includes/exportUserOrders.inc.php">
      <input type="hidden" name="userID" value="<?php echo $userID; ?>">
      <input type="hidden" name="totalSum" value="<?php echo $totalSum; ?>">
      <input type="submit" name="export" value="Export to Excel" class="btn">
    </form>
  </div>

  <table>
    <?php include 'includes/userOrdersTable.php'; ?>
    <?php 
        foreach($orders as $order){
            $totalPrice = $order['price'] + $order['color_price'];
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
            echo "<td>".$order['price']." €</td>";
            echo "<td>".$order['color_price']." €</td>";
            echo "<td>".$totalPrice." €</td>";
            echo "</tr>";
        }
    ?>
  </table>
  <div class="divider"></div>
  <div class="Total-price-container">
    <?php
      if($totalSum){
        echo"<strong class='total-price'>Total: $totalSum €</strong>";
      }
      else {
        echo"<strong class='total-price'>Total price: 0 €</strong>";
      }
    ?>
  </div>
 
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

<script>
    document.getElementById('avatar').addEventListener('change', function() {
        document.getElementById('avatarForm').submit(); // Автоматически отправить форму при выборе файла
    });
</script>



</body>
<?php include 'footer.php'; ?>