<?php
    session_start(); //Start the session.
    require_once 'connection.php'; //Require connection file to connect to database.
    
    if(isset($_POST['username']) & isset($_POST['password'])) //if email and password are set.
    {
       $userPassword = $_POST['password'];//Get password and username
       $username = $_POST['username'];
        
       $hashedPassword = md5($userPassword);//Getting the hash to compare
        
       $SQL_stmt = "SELECT userID, username, email, password, roleID FROM user
       WHERE username = '".$username."' AND password = '".$hashedPassword."'";
        
       //$result = 0;
        
       $result = $DBconnection->query($SQL_stmt);
       
        
       if($row = $result->fetch())
       {
          //If there is a result, set the session variables
          $_SESSION['userID'] = $row['userID'];
          $_SESSION['username'] = $row['username'];
          $_SESSION['email'] = $row['email'];
          $_SESSION['roleID'] = $row['roleID'];
    
          header('location:../autosalons/index.php?activity=login_successfull');
       }
       else //if there is no result
       {
        
           header('location:index.php?activity=incorrect_user_login_credentials');
           
       }
    }
    else
    {
        header('location:index.php?activity=email_or_password_not_set');
    }
?>