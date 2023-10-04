<?php
require_once 'connection.php';
require_once 'user.php';

if (isset($_SESSION['success'])) {
    $userID = $_SESSION['userID']; // идентификатор пользователя
    $user = new UserMain($userID); // объект UserMain
    $avatarURL = $user->getPicture(); // URL аватарки пользователя
}
?>

<head>    
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js' integrity='sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="css/homepage.css">
    <link rel="stylesheet" href="css/headers.css">
    <script src="../autosalons/js/script.js" defer></script>

</head>

<body>
    <header class="p-3 mb-3 border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-right justify-content-lg-start">
        <a href="#" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-right mb-md-0" style="position: absolute; right: 0;">
          <li><a href='#' class="nav-link px-2 link-secondary" onClick='RedToHomepage()'>Homepage</a></li>
          <li><a href='#about-us' class="nav-link px-2 link-dark">About Us</a></li>

          <!-- Для переадресации на страницу со всеми заказами -->
          <script>
            function RedToOrdersPage() {
              window.location.href = "ordersPage.php";
            }
          </script>

          <!-- Для переадресации на страницу с добавлением предложений -->
          <script>
            function RedToEditOffers() {
                window.location.href="../autosalons/editOffersPage.php"; 
            }
          </script>

          <?php 
          if (isset($_SESSION['success'])) { ?>
            <li>
              <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#notificationModal">
                <i class="bi bi-bell">🔔</i>
              </button>
            </li>
            <li>
              <div class="dropdown text-end">
                <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                  <img src="<?php echo $avatarURL; ?>" alt="Avatar" width="40" height="40" class="rounded-circle">
                </a>
                <ul class="dropdown-menu text-small">
                  <li><a class="dropdown-item" href="#" onClick="RedToProfile()">Profile & Orders</a></li>
                  <?php if ($_SESSION['roleID'] == 1) { ?>
                    <li><a class="dropdown-item" href="#" onClick="RedToOrdersPage()">All orders</a></li>
                    <li><a class="dropdown-item" href="#" onClick="RedToEditOffers()">Offers</a></li>
                  <?php } ?>
                  <li><a class="dropdown-item" href="#" onClick="RedToForum()">Forum</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a href="logout.php" class="dropdown-item">Sign out</a></li>
                </ul>
              </div>
            </li>
          <?php } else { ?>
            <li><a href="#" class="nav-link px-2 link-dark" onClick="RedToRegistration()">Registration</a></li>
            <li><a href="#" class="nav-link px-2 link-dark" onclick="RedToLogin()">Login</a></li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </header>

  <!-- Модальное окно с уведомлениями -->
  <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="notificationModalLabel">Notifications</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Здесь будет содержимое модального окна с уведомлениями -->
          <!-- Можете добавить список уведомлений или другие элементы по вашему выбору -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</body>
