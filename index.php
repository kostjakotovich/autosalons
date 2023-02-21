<?php

require_once 'connection.php';

$sql = "SELECT * FROM comments ORDER BY commentID DESC";
$result = $DBconnection->query($sql);
?>

    <html>
    <head>
      <title>Formu aizpildīšana</title>
      
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <script src="../autosalons/script.js" defer></script>
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


        <div class="dropdown text-end">
          <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small">
            <li><a class="dropdown-item" href="#">New project...</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="#" onClick="RedToProfile()">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Sign out</a></li>
          </ul>
        </div>
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

      <form>

      <?php 

        $conn = mysqli_connect($servername, $username, $password, $dbname);
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


