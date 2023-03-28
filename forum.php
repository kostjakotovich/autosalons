<?php
session_start(); //Start the session.
require_once 'connection.php';

$sql2 = "SELECT userID, username, email, password FROM user";
$result2 = mysqli_query($conn, $sql2);
$sql = "SELECT * FROM comments ORDER BY commentID DESC";
$result = $conn->query($sql);
$row2 = mysqli_fetch_assoc($result2);
?>
<head>
    <script src="../autosalons/js/script.js" defer></script>
    <p>Forum</p>
</head>
<body>
    <script src="../autosalons/js/script.js" defer></script>

    <button class="button" id="redirecttoindex" onClick="RedToComments()">Home page</button>
    
    <form action='submit.php' method='post'>
            <label for='name'>Name:</label>
            <input type='text' id='name' name='name'>

    
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


            if(isset($_GET["success"])){
                if($_GET["success"] =="suc"){
                    echo "<script>alert('Jūs veiksmīgi atstājāt komentāriju!')</script>";
                }
              };
    ?>
</body>