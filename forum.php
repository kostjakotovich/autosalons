<?php
session_start();
require_once 'connection.php';

class Profile {
    private $DBconnection;

    function __construct($DBconnection) {
        $this->DBconnection = $DBconnection;
    }

    function displayComments() {
        $sql = "SELECT commentID, name, email, comment FROM comments";
        $stmt = $this->DBconnection->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            while($row = $stmt->fetch()) {
                echo "Name: " . $row["name"]. " - Email: " . $row["email"]. " - Comment: " . $row["comment"]. "<br>";
                ?>
                <a href="delete.php?commentID=<?php echo $row["commentID"]; ?>">Delete</a>
                <br></br>
                <?php
            }
        } else {
            echo "0 results";
        }
    }
}

$db = new database();
$DBconnection = $db->getDBConnection();
$profile = new Profile($DBconnection);
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
        $profile->displayComments();

        if(isset($_GET["success"])){
            if($_GET["success"] =="suc"){
                echo "<script>alert('Jūs veiksmīgi atstājāt komentāriju!')</script>";
            }
        };
    ?>
</body>
