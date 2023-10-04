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

    public function getPicture() {
        $sql = "SELECT picture FROM user WHERE userID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$this->userID]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['picture'];
    }
    
    public function updatePicture($pictureURL) {
        $sql = "UPDATE user SET picture = ? WHERE userID = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$pictureURL, $this->userID]);
    }
    
    public function getNotifications() {
        if (isset($_SESSION['userID'])) {
            $this->userID = $_SESSION['userID'];
            $sql = "SELECT * FROM notifications WHERE userID = :userID Order by created_at desc";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array(':userID' => $this->userID));
            $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $notifications;
        }
    }
    
    public function deleteNotification($notificationID) {
        $sql = "DELETE FROM notifications WHERE notification_id = :notificationID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':notificationID', $notificationID, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
      
}
?>
