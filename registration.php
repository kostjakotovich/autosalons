<?php
session_start();
require_once 'connection.php';
require_once 'User.php';

class UserRegistration extends UserMain {
    private $conn;

    public function __construct($username, $email, $password) {
        parent::__construct(null);
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->conn = (new Database())->connect();
    }

    public function registration() {
        $errors = array();
        if (isset($_POST['reg'])) {
            // Получаем все значения из формы

            if (empty($this->username)) { array_push($errors, "Username is required");}
            if (empty($this->email)) { array_push($errors, "Email is required");}
            if (empty($this->password)) { array_push($errors, "Password is required");}
            if (empty($this->password)) { array_push($errors, "Verify your password");}

            if ($this->password !== $_POST['password_confirm']) {
                array_push($errors, "Passwords do not match");
            }

            $result = $this->conn->prepare("SELECT * FROM user WHERE username=:username OR email=:email LIMIT 1");

            $result->execute(array(':username' => $this->username, ':email' => $this->email));
            $user = $result->fetch();

            if ($user) { // если пользователь существует
                if ($user['username'] === $this->username) {
                    array_push($errors, "Username already exists!");

                }

                if ($user['email'] === $this->email) {
                    array_push($errors, "Email already exists!");

                }
            }

            // Регистрируем пользователя, если нет ошибок в форме
            if (count($errors) == 0) {
                $passwordHash = password_hash($this->password, PASSWORD_DEFAULT);
                 // хешируем пароль перед сохранением в базе данных
            
                 $result = $this->conn->prepare("INSERT INTO user (username, email, password, roleID) VALUES(:username, :email, :password, :roleID)");
                if(!$result->execute(array(':username' => $this->username, ':email' => $this->email, ':password' => $passwordHash, ':roleID' => 0))) {
                    $result = null;
                    $_SESSION['error'] = 'Failed to register';
                }
                else {
                    $_SESSION['success'] = 'Registration successful';
                }
                
                $result = null;
                
                // Получаем ID только что зарегистрированного пользователя
                $result = $this->conn->prepare("SELECT userID FROM user WHERE email=:email");
                $result->execute(array(':email' => $this->email));
                $user = $result->fetch();
                $_SESSION['userID'] = $user['userID'];
            
                header('location: index.php');
            }
            else {
                $_SESSION['error'] = implode("<br>", $errors);
                header('location: registrationPage.php');
            }
        }
        else {
            $_SESSION['error'] = 'Invalid request';
            header('location: registrationPage.php');
        }
    }
}


$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];   

$user = new UserRegistration($_POST['username'], $_POST['email'], $_POST['password']);
$user->registration();

?>
