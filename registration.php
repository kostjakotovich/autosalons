<?php 
    session_start();
    require_once 'connection.php';
    
// initializing variables
$username = "";
$email = "";
$errors = array();


//REGISTER USER
if (isset($_POST['reg_user'])) {
    //receive all input values from the form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];


    if (empty($username)) { array_push($errors, "Username is required");}
    if (empty($email)) { array_push($errors, "Email is required");}
    if (empty($password)) { array_push($errors, "Password is required");}

    $user_check_query = "SELECT * FROM user WHERE username='$username' OR email='$email' LIMIT 1";

    $result = $DBconnection->query($user_check_query);
    $user = $result->fetch();

    if ($user) { //if user exists
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists!");

        }

        if ($user['email'] === $email) {
            array_push($errors, "email already exists");
  
        }
    }

    //FInally, register user if there are no earrors in the form
    if (COUNT($errors) == 0) {
        $passwordMD5 = md5($password); //encrypt the password beofre saving in the database

        $query = "INSERT INTO user (username, email, password, roleID)
                  VALUES('$username', '$email', '$passwordMD5', 0)";
        $DBconnection->query($query);
        $_SESSION['username'] = $username;
        header('location: index.php');
    }
    else //if there is no result
    {
        header('location:index.php?activity=username_or_email_taken');
        
    }
}
else 
{
    header('location: index.php?acitivity=username_or_email_not_set ');
}



?>