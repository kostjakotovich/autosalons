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

    /* Profile methods */
    public function getUserInfo() {
        $sql = "SELECT username, email FROM user WHERE userID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$this->userID]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

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

            $topicName = 'Profile';
            $topicID = $this->getNotificationTopicIDByName($topicName);
            
            $notificationText = "Your password has been successfully changed!";
            $this->addNotification($topicID, $notificationText);

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
        return $stmt->fetchColumn();
    }    
    
    public function updatePicture($newPictureURL) {
        $sql = "SELECT picture FROM user WHERE userID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$this->userID]);
        $currentPictureURL = $stmt->fetchColumn();
    
        if ($currentPictureURL && basename($currentPictureURL) !== 'default.png') {
            $currentPicturePath = __DIR__ . '/../' . $currentPictureURL;
            if (file_exists($currentPicturePath)) {
                unlink($currentPicturePath);
            }
        }
    
        $sql = "UPDATE user SET picture = ? WHERE userID = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$newPictureURL, $this->userID]);
    }
    
    
    /* Notifications methods */
    public function addNotification($topicID, $message) {
        $stmt = $this->conn->prepare("INSERT INTO notifications (topic_id, message) VALUES (:topicID, :message)");
        $stmt->bindParam(':topicID', $topicID, PDO::PARAM_INT);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);
        $stmt->execute();
    }
    
    public function getNotifications() {
        $sql = "SELECT n.*, nt.topic_name 
                FROM notifications n 
                INNER JOIN notification_topics nt ON n.topic_id = nt.topic_id
                WHERE nt.userID = :userID AND nt.status = 'enable' 
                ORDER BY n.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userID', $this->userID, PDO::PARAM_INT);
        $stmt->execute();
        $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $notifications;
    }    
    
    public function deleteNotification($notificationID) {
        $sql = "DELETE FROM notifications WHERE notification_id = :notificationID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':notificationID', $notificationID, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteAllNotifications() {
        $sql = "DELETE FROM notifications 
                WHERE topic_id IN (SELECT topic_id FROM notification_topics WHERE userID = :userID)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userID', $this->userID, PDO::PARAM_INT);
        return $stmt->execute();
    }    

    public function getNotificationTopics() {
        $sql = "SELECT * FROM notification_topics WHERE userID = :userID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userID', $this->userID, PDO::PARAM_INT);
        $stmt->execute();
        $topics = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $topics;
    }

    public function getNotificationTopicIDByName($topicName) {
        $sql = "SELECT topic_id FROM notification_topics WHERE topic_name = :topicName AND userID = :userID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':topicName', $topicName, PDO::PARAM_STR);
        $stmt->bindParam(':userID', $this->userID, PDO::PARAM_INT);
        $stmt->execute();
        $topicID = $stmt->fetchColumn();
        return $topicID;
    }  

    public function updateNotificationTopicStatus($topicID, $status) {
        $sql = "UPDATE notification_topics SET status = :status WHERE topic_id = :topicID AND userID = :userID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':topicID', $topicID, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':userID', $this->userID, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getNotificationTopicStatus($topicID) {
        $sql = "SELECT status FROM notification_topics WHERE topic_id = :topicID AND userID = :userID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':topicID', $topicID, PDO::PARAM_INT);
        $stmt->bindParam(':userID', $this->userID, PDO::PARAM_INT);
        $stmt->execute();
        $status = $stmt->fetchColumn();
        return $status;
    }

    public function addDefaultNotificationTopics() {
        $topics = ['Forum', 'Orders', 'Profile'];
        foreach ($topics as $topicName) {
            $topicID = $this->getNotificationTopicIDByName($topicName);
            if (!$topicID) {
                $status = 'enable';
                $this->insertNotificationTopic($topicName, $status);
            }
        }
    }

    private function insertNotificationTopic($topicName, $status) {
        $sql = "INSERT INTO notification_topics (userID, topic_name, status) VALUES (:userID, :topicName, :status)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userID', $this->userID, PDO::PARAM_INT);
        $stmt->bindParam(':topicName', $topicName, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->execute();
    }

    /* Rules methods */
    public function isRulesAccepted() {
        $sql = "SELECT rules_accepted FROM user WHERE userID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$this->userID]);
        $rulesAccepted = $stmt->fetchColumn();
        return $rulesAccepted === 1;
    }    

    public function acceptRules() {
        $sql = "UPDATE user SET rules_accepted = 1 WHERE userID = ?";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $this->userID, PDO::PARAM_INT);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
    

}
?>
