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
}
?>
