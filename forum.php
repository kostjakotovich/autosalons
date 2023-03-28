<form action='submit.php' method='post'>
        <label for='name'>Name:</label>
        <input type='text' id='name' name='name'>
  
        <label for='email'>E-mail:</label>
        <input type='email' id='email' name='email'>
  
        <label for='comment'>Comment:</label>
        <textarea id='comment' name='comment'></textarea>
  
        <input type='submit' value='Submit'>
        
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