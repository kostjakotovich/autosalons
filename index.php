<?php
session_start(); //Start the session.
require_once 'connection.php';

$sql = "SELECT * FROM comments ORDER BY commentID DESC";
$result = $DBconnection->query($sql);
?>

    <html>
    <head>
      
      
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <link rel="stylesheet" href="../css/index.css">
      <script src="../autosalons/js/script.js" defer></script>
      <script src="../autosalons/js/registration.js" defer></script>
    </head>
    <body>
    <header class="p-3 mb-3 border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0" style="margin-left: auto; 
margin-right: 0;">
          <li><a href="#" class="nav-link px-2 link-secondary">Overview</a></li>
          <li><a href="#" class="nav-link px-2 link-dark">Inventory</a></li>
          <li><a href="#" class="nav-link px-2 link-dark">Customers</a></li>
          <li><a href="#" class="nav-link px-2 link-dark">Products</a></li>
        </ul>

        <?php 
            if (isset($_SESSION['username'])) {
                echo "<div class='dropdown text-end'>
                <a href='#' class='d-block link-dark text-decoration-none dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'>
                        <img src='https://github.com/mdo.png' alt='mdo' width='32' height='32' class='rounded-circle'>
                      </a>
                      <ul class='dropdown-menu text-small'>
                        <li><a class='dropdown-item' href='#'>New project...</a></li>
                        <li><a class='dropdown-item' href='#' onClick='RedToForum()'>Forum</a></li>
                        <li><a class='dropdown-item' href='#' onClick='RedToProfile()'>Profile</a></li>
                        <li><hr class='dropdown-divider'></li>
                        <li><a href='logout.php' class='logreg'>Sign out</a></li>
                      </ul>
                    </div>";
                
                
            }
            else {
                echo "<a href='#' class='logreg' onClick='RedToRegistration()'>Registration/</a>";
                echo "<a href='#' class='logreg' onclick='RedToLogin()'>Login</a>";
            }
          ?>
          
      </div>
    </div>
  </header>

      <form action="phpSearchOption.php" method="post">
          <input type="text" placeholder="Search.." name="search" style="width: 100%;
  box-sizing: border-box;
  border: 2px solid #ccc;
  border-radius: 4px;
  font-size: 16px;
  background-color: white;
  background-image: url('searchicon.png');
  background-position: 10px 10px; 
  background-repeat: no-repeat;
  padding: 12px 20px 12px 40px";><br>

          Meklēt pēc: <select name="column">
            <option value="name">Name</option>
            <option value="email">Email</option>
            </select><br>
          <input type ="submit">
      </form>

      <button class="button" id="redirecttoprofile" onClick="RedToProfile()">Profils</button>

    <?php
      
    echo "
      </form>
      <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js' integrity='sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN' crossorigin='anonymous'></script>
    </body>
  </html>
  
  
  ";

  if(isset($_GET["success"])){
    if($_GET["success"] =="suc"){
        echo "<script>alert('Jūs esat ielagojies!')</script>";
    }
  };

  ?>


  


