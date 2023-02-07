
<?php
session_start(); //Start the session.
require_once 'connection.php';

    echo "
    <html>
    <head>
      <title>Form Example</title>
    </head>
    <body>
      <form action='submit.php' method='post'>
        <label for='name'>Name:</label>
        <input type='text' id='name' name='name'>
  
        <label for='email'>E-mail:</label>
        <input type='email' id='email' name='email'>
  
        <label for='comment'>Comment:</label>
        <textarea id='comment' name='comment'></textarea>
  
        <input type='submit' value='Submit'>
        
      </form>

      <form> " ?>

      <?php 
        

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
      
        $sql = "SELECT name, email, comment FROM comments";
        $result = mysqli_query($conn, $sql);
      
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                echo "Name: " . $row["name"]. " - Email: " . $row["email"]. " - Comment: " . $row["comment"]. "<br>";
                echo "<a href="deleteNews.php?Info_ID=<?php echo $row["Info_ID"]; ?>">Delete</a>"
            }
        } else {
            echo "0 results";
        }
      
        mysqli_close($conn);
      
    echo "
      </form>

    </body>
  </html>
  
  
  ";
  if(isset($_GET["success"])){
    if($_GET["success"] =="suc"){
        echo "<script>alert('Jūs esat ielagojies!')</script>";
    }
  }
?>