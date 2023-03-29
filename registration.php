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
            // Получаем все значения из формы

            if (empty($this->username)) { array_push($errors, "Username is required");}
            if (empty($this->email)) { array_push($errors, "Email is required");}
            if (empty($this->password)) { array_push($errors, "Password is required");}

            $result = $this->connect()->prepare("SELECT * FROM user WHERE username=:username OR email=:email LIMIT 1");
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
            
                $result = $this->connect()->prepare("INSERT INTO user (username, email, password, roleID) VALUES(:username, :email, :password, :roleID)");
                if(!$result->execute(array(':username' => $this->username, ':email' => $this->email, ':password' => $passwordHash, ':roleID' => 0))) {
                    $result = null;
                    $_SESSION['error'] = 'Failed to register';
                }
                else {
                    $_SESSION['success'] = 'Registration successful';
                }
                
                $result = null;
                
                // Получаем ID только что зарегистрированного пользователя
                $result = $this->connect()->prepare("SELECT userID FROM user WHERE email=:email");
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

$user = new user($username, $email, $password);
$user->registration();

?>
