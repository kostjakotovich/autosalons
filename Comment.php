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
    $sql = "SELECT COUNT(*) as total FROM comments";
    $stmt = $this->conn->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
}


    public function getTotalCommentsCountForPage($startIndex, $endIndex) {
        $sql = "SELECT COUNT(*) as count FROM comments LIMIT :startIndex, :endIndex";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':startIndex', $startIndex, PDO::PARAM_INT);
        $stmt->bindParam(':endIndex', $endIndex, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'];
    }
    

    public function getCommentsForPage($startIndex, $commentsPerPage) {
        $sql = "SELECT comments.comment, user.username, comments.date 
                FROM comments 
                JOIN user ON comments.userID = user.userID 
                ORDER BY comments.commentID DESC
                LIMIT :startIndex, :commentsPerPage";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':startIndex', (int) $startIndex, PDO::PARAM_INT);
        $stmt->bindValue(':commentsPerPage', (int) $commentsPerPage, PDO::PARAM_INT);
        $stmt->execute();

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
