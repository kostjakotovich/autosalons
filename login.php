
<?php
session_start();
require_once 'connection.php'; //Require connection file to connect to database.

        //get the user with the email
        $sql = "SELECT * FROM user WHERE username = '".$_POST['username']."'";
        $query = $conn->query($sql);
        if($query->num_rows > 0){
            $row = $query->fetch_assoc();
            //verify password
            if(password($_POST['password'], $row['password'])){
                //action after a successful login
                //for now just message a successful login
                $_SESSION['success'] = 'Login successful';
                //unset our attempt
            }
            else{
                $_SESSION['error'] = 'Password incorrect';
                //this is where we put our 3 attempt limit
            }
        }
        else{
            $_SESSION['error'] = 'No account with that username';
        }

    

header('location: index.php');

?>