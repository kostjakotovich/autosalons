<?php 
    session_start();
    require_once 'connection.php';
    
// initializing variables
class user extends database{
    private $username;
    private $email;
    private $password;

    public function __construct($username, $email, $password){
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public function registration(){
        $errors = array();
        if (isset($_POST['reg'])) {
            //receive all input values from the form


            if (empty($this->username)) { array_push($errors, "Username is required");}
            if (empty($this->email)) { array_push($errors, "Email is required");}
            if (empty($this->password)) { array_push($errors, "Password is required");}
        
            
        
            $result = $this->connect()->prepare("SELECT * FROM user WHERE username='$this->username' OR email='$this->email' LIMIT 1");
            $user = $result->fetch();
        
            if ($user) { //if user exists
                if ($user['username'] === $this->username) {
                    array_push($errors, "Username already exists!");
        
                }
        
                if ($user['email'] === $this->email) {
                    array_push($errors, "email already exists");
          
                }
            }
        
            //FInally, register user if there are no earrors in the form
            if (COUNT($errors) == 0) {
                $passwordMD5 = md5($this->password); //encrypt the password beofre saving in the database
        
                
                
                $result = $this->connect()->prepare("INSERT INTO user (username, email, password, roleID) VALUES(:username, :email, :password, :roleID)");
                if(!$result->execute(array(':username' => $this->username, ':email' => $this->email, ':password' => $passwordMD5, ':roleID' => 0))) {
                    $result = null;
                    header("location: registration.php?error=stmtfailed");
                    exit();
                }
                $result = null;
                $_SESSION['username'] = $this->username;
                header('location: index.php');
            }
            else //if there is no result
            {
                header('location:registrationPage.php?activity=username_or_email_taken');
                
            }
        }
        else 
        {
            header('location: registrationPage.php?acitivity=username_or_email_not_set ');
        }
    }
}


$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];   

$user = new user($username, $email, $password);
$user->registration();