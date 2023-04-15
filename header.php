<?php
require_once 'connection.php';
?>

<head>    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/homepage.css">
    <link rel="stylesheet" href="css/headers.css">
    <script src="../autosalons/js/script.js" defer></script>
</head>

    <header class="p-3 mb-3 border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-right justify-content-lg-start">
        <a href="#" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-right mb-md-0" style="position: absolute;
                  right: 0;">
          <li><a href='#' class="nav-link px-2 link-secondary" onClick='RedToHomepage()'>Homepage</a></li>
          <li><a href="#" class="nav-link px-2 link-dark">Inventory</a></li>
          <li><a href="#" class="nav-link px-2 link-dark">Customers</a></li>
          <li><a href="#" class="nav-link px-2 link-dark">Products</a></li>
        
          <!--  Для переадресации на страницу со семи заказами-->
          <script>
            function RedToOrdersPage() {
              window.location.href = "ordersPage.php";
            }
          </script>


        <?php 
            if (isset($_SESSION['success'])) {
                echo " <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js' integrity='sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN' crossorigin='anonymous'></script>
                <div class='dropdown text-end'>
                <a href='#' class='d-block link-dark text-decoration-none dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'>
                        <img src='https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS2vRsFCw0zkeM9IE-PfdAWbPUJ4GHKn9ouAw&usqp=CAU' alt='mdo' width='32' height='32' class='rounded-circle'>
                      </a>
                      <ul class='dropdown-menu text-small'>
                        <li><a class='dropdown-item' href='#' onClick='RedToProfile()'>Profile & Orders</a></li>";
                        if ($_SESSION['roleID'] == 1) {
                          echo "<li><a class='dropdown-item' href='#' onClick='RedToOrdersPage()'>All orders</a></li>
                          <li><a class='dropdown-item' href='#' onClick='RedToProfile()'>Offers</a></li>";
                        }                       
                        echo "<li><a class='dropdown-item' href='#' onClick='RedToForum()'>Forum</a></li>
                        <li><hr class='dropdown-divider'></li>
                        <li><a href='logout.php' class='dropdown-item'>Sign out</a></li>
                      </ul>
                    </div>";
                
                
            }
            else {
                echo "<a href='#' class='nav-link px-2 link-dark' onClick='RedToRegistration()'>Registration</a>";
                echo "<a href='#' class='nav-link px-2 link-dark' onclick='RedToLogin()'>Login</a>";
            }
          ?>
          </ul>
      </div>
    </div>
  </header>