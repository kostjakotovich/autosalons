<?php
require_once 'connection.php';

class UserMain {
    private $username;
    private $email;
    private $password;
    private $password_hash;

    public function __construct($userID){
        $this->userID = $userID;
        $this->conn = (new Database())->connect();
    }

    private $userID;
    private $conn;

    public function getUserInfo() {
        $sql = "SELECT username, email FROM user WHERE userID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$this->userID]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    // Новый метод, который возвращает значение поля password
    public function getPassword() {
        $stmt = $this->conn->prepare("SELECT password FROM user WHERE userID = :userID");
        $stmt->bindParam(':userID', $this->userID, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if (count($result) == 1) {
            $row = $result[0];
            return $row['password'];
        } else {
            return "";
        }
    }

    public function verifyPassword($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }
    

    public function getPasswordHash() {
        return $this->password_hash;
    }

    public function changePassword($currentPassword, $newPassword, $confirmPassword) {
        try {
          $stmt = $this->conn->prepare("SELECT password FROM user WHERE userID = :userID");
          $stmt->bindParam(':userID', $this->userID);
          $stmt->execute();
          $result = $stmt->fetch();
    
          if(password_verify($currentPassword, $result['password']) && $newPassword == $confirmPassword) {
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare("UPDATE user SET password = :newPassword WHERE userID = :userID");
            $stmt->bindParam(':newPassword', $newPasswordHash);
            $stmt->bindParam(':userID', $this->userID);
            $stmt->execute();
            return true;
          } else {
            return false;
          }
        } catch(PDOException $e) {
          echo "Error: " . $e->getMessage();
          return false;
        }
    }
      
}
?>
