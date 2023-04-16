<?php
require_once 'connection.php';

class Comment {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function getAllComments() {
        $sql = "SELECT comments.comment, user.username, comments.date 
                FROM comments 
                JOIN user ON comments.userID = user.userID 
                ORDER BY comments.commentID DESC";

        $stmt = $this->conn->query($sql);

        $comments = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $comment = array(
                'username' => $row['username'],
                'comment' => $row['comment'],
                'date' => $row['date']
            );

            $comments[] = $comment;
        }

        return $comments;
    }

    public function addComment($comment, $userID) {
        date_default_timezone_set('Europe/Riga');
        $date = date("Y-m-d H:i:s");

        $sql = "INSERT INTO comments (comment, userID, date) VALUES (:comment, :userID, :date)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
    }

    public function getTotalCommentsCount() {
        $sql = "SELECT COUNT(*) FROM comments";
        $stmt = $this->conn->query($sql);
        $count = $stmt->fetchColumn();
        return $count;
    }

    public function getCommentsForPage($startIndex, $endIndex) {
        $sql = "SELECT comments.comment, user.username, comments.date 
                FROM comments 
                JOIN user ON comments.userID = user.userID 
                ORDER BY comments.commentID DESC 
                LIMIT $startIndex, $endIndex";

        $stmt = $this->conn->query($sql);

        $comments = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $comment = array(
                'username' => $row['username'],
                'comment' => $row['comment'],
                'date' => $row['date']
            );

            $comments[] = $comment;
        }

        return $comments;
    }
}