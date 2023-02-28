<?php
session_start(); //Start the session.
require_once 'connection.php';

$sql = "SELECT * FROM comments ORDER BY commentID DESC";
$result = $DBconnection->query($sql);
?>

    <html>
    <head>
      <title>Formu aizpildīšana</title>
      
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <link rel="stylesheet" href="..autosalons/css/index.css">
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

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
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
                        <li><a class='dropdown-item' href='#'>Settings</a></li>
                        <li><a class='dropdown-item' href='#' onClick='RedToProfile()'>Profile</a></li>
                        <li><hr class='dropdown-divider'></li>
                        <li><a href='logout.php' class='logreg'>Sign out</a></li>
                      </ul>
                    </div>";
                
                
            }
            else {
                echo "<a href='#' class='logreg' onclick='openRegistration()'>Registration</a>";
                echo "<a href='#' class='logreg' onclick='openLogin()'>Login</a>";
            }
          ?>
          
      </div>
    </div>
  </header>

      <form action="phpSearchOption.php" method="post">
          Search <input type="text" name="search"><br>

          Column: <select name="column">
            <option value="name">Name</option>
            <option value="email">Email</option>
            </select><br>
          <input type ="submit">
      </form>

      <button class="button" id="redirecttoprofile" onClick="RedToProfile()">Profils</button>

      <form action='submit.php' method='post'>
        <label for='name'>Name:</label>
        <input type='text' id='name' name='name'>
  
        <label for='email'>E-mail:</label>
        <input type='email' id='email' name='email'>
  
        <label for='comment'>Comment:</label>
        <textarea id='comment' name='comment'></textarea>
  
        <input type='submit' value='Submit'>
        
      </form>

      <!-- LOGIN FORM -->


    <form class="form-container" method="POST" action="login.php" id="js_login">
        <div class="login-block" id="js_login" >
            <h1>Login</h1>
            <input type="text" value="" placeholder="Username" name="username" id="username" />
            <input type="password" value="" placeholder="Password" name="password" id="password" />
            <button type="submit">Submit</button>
            <button id="cancel" onclick="closeLogin()">Cancel</button>
        </div>
    </form>

    <!-- REGISTRATION FORM -->
    <div class="modal fade" id="modalRegisterForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Sign up</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="md-form mb-5">
          <i class="fas fa-user prefix grey-text"></i>
          <input type="text" id="orangeForm-name" class="form-control validate">
          <label data-error="wrong" data-success="right" for="orangeForm-name">Your name</label>
        </div>
        <div class="md-form mb-5">
          <i class="fas fa-envelope prefix grey-text"></i>
          <input type="email" id="orangeForm-email" class="form-control validate">
          <label data-error="wrong" data-success="right" for="orangeForm-email">Your email</label>
        </div>

        <div class="md-form mb-4">
          <i class="fas fa-lock prefix grey-text"></i>
          <input type="password" id="orangeForm-pass" class="form-control validate">
          <label data-error="wrong" data-success="right" for="orangeForm-pass">Your password</label>
        </div>

      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-deep-orange">Sign up</button>
      </div>
    </div>
  </div>
</div>

<div class="text-center">
  <a href="" class="btn btn-default btn-rounded mb-4" data-toggle="modal" data-target="#modalRegisterForm">Launch
    Modal Register Form</a>
</div>

    <form class="form-container" action="registration.php" method="POST" id="jsReg">
        <div class="registration-block">
            <h1>Registration</h1>
            <input type="text" value="" placeholder="Username" name="username" id="username2" />
            <input type="email" value="" placeholder="E-mail" name="email" id="email"/>
            <input type="password" value="" placeholder="Password" name="password" id="password2"/>
            <button type="submit" name="reg_user">Register</button>
            <button id="cancel" onclick="closeRegistration()">Cancel</button>
        </div>
    </form>

      <?php 

        $conn = mysqli_connect($servername, $DBusername, $DBpassword, $dbname);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
      
        $sql = "SELECT commentID, name, email, comment FROM comments";
        $result = mysqli_query($conn, $sql);
      
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                
                echo "Name: " . $row["name"]. " - Email: " . $row["email"]. " - Comment: " . $row["comment"]. "<br>";
                ?>
                <a href="delete.php?commentID=<?php echo $row["commentID"]; ?>">Delete</a>
                <br></br>
                <?php
            }
        } else {
            echo "0 results";
        }
      
        mysqli_close($conn);
      
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


  


