<?php
require_once 'connection.php';

class UserMain {
    private $username;
    private $email;
    private $password;

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
