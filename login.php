<?php
session_start();
require_once 'connection.php';

class Login {
  private $db;

  public function __construct(database $db) {
    $this->db = $db;
  }

  public function login($username, $password) {
    $conn = $this->db->connect();

    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION["userID"] = $row["userID"];

    if($row){
        //verify password
        if(password_verify($password, $row['password']))
        {
            //action after a successful login
            //for now just message a successful login
            
            $_SESSION['success'] = 'Login successful';
            header('location: index.php');
        }
        else{
            $_SESSION['error'] = 'Password incorrect';
            header('location: loginPage.php');
        }
    }
    else{
        $_SESSION['error'] = 'No account with that username';
        header('location: loginPage.php');
    }
  }
}

if(isset($_POST['username']) && isset($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $login = new Login(new database());
    $login->login($username, $password);
}
else{
    $_SESSION['error'] = 'Please enter a username and password';
    header('location: loginPage.php');
}

?>
