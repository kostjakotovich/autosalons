<?php
require_once 'connection.php';
require_once 'user.php';

class Comment {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
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

    public function deleteComment($commentID) {
        $sql = "DELETE FROM comments WHERE commentID = :commentID";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':commentID', $commentID, PDO::PARAM_INT);
        $stmt->execute();
    }

    

    public function getTotalOriginalCommentsCount() {
    $sql = "SELECT COUNT(*) as total FROM comments WHERE comments.parent_comment_id IS NULL";
    $stmt = $this->conn->query($sql);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
    }

    // Метод для получения оригинальных комментариев
    public function getOriginalCommentsForPage($startIndex, $commentsPerPage) {
        $sql = "SELECT comments.commentID, comments.userID, comments.comment, user.username, comments.date
                FROM comments 
                LEFT JOIN user ON comments.userID = user.userID 
                WHERE comments.parent_comment_id IS NULL 
                ORDER BY comments.commentID DESC
                LIMIT :startIndex, :commentsPerPage";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':startIndex', (int) $startIndex, PDO::PARAM_INT);
        $stmt->bindValue(':commentsPerPage', (int) $commentsPerPage, PDO::PARAM_INT);
        $stmt->execute();

        $comments = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $comment = array(
                'commentID' => $row['commentID'],
                'userID' => $row['userID'],
                'username' => $row['username'],
                'comment' => $row['comment'],
                'date' => $row['date']
            );

            $comments[] = $comment;
        }

        return $comments;
    }

    public function addReply($comment, $userID, $parentCommentID) {
        date_default_timezone_set('Europe/Riga');
        $date = date("Y-m-d H:i:s");
    
        // Получаем username пользователя, который оставил ответ
        $replyUsername = $this->getUsernameByUserID($userID);
    
        // Получаем userID пользователя оригинального комментария
        $originalCommentUserID = $this->getUserIDForOriginalComment($parentCommentID);
    
        $sql = "INSERT INTO comments (comment, userID, date, parent_comment_id) VALUES (:comment, :userID, :date, :parentCommentID)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':parentCommentID', $parentCommentID);
        $stmt->execute();
    
        $maxMessageLength = 100; // Максимальная длина сообщения
        if (strlen($comment) > $maxMessageLength) {
            $truncatedMessage = substr($comment, 0, $maxMessageLength) . "...";
            $notificationText = "You have received a reply from '$replyUsername' to your comment: '$truncatedMessage'. For the full message, visit the <a href='forum.php'>forum</a>.";

        } else {
            $notificationText = "You have received a reply from '$replyUsername' to your comment: '$comment'. Visit the <a href='forum.php'>forum</a> to view the response.";
        }

        $userMain = new UserMain($userID);
            
        $topicName = 'Forum';
        $topicID = $userMain->getNotificationTopicIDByName($topicName);
            
        $userMain->addNotification($topicID, $notificationText);
    }
    
    
    
    // Метод для получения ответов на комментарии
    public function getRepliesForComment($parentCommentID) {
        $replies = array();
        $this->getRepliesRecursive($parentCommentID, $replies);
        
        // Сортировка массива $replies по дате
        usort($replies, function($a, $b) {
            return strtotime($a['date']) - strtotime($b['date']);
        });
        
        return $replies;
    }

    // Рекурсивная функция для получения всех ответов на комментарии
    private function getRepliesRecursive($parentCommentID, &$replies) {
        $sql = "SELECT comments.commentID, comments.userID, user.username, comments.comment, comments.date 
                FROM comments 
                INNER JOIN user ON comments.userID = user.userID 
                WHERE comments.parent_comment_id = :parentCommentID
                ORDER BY comments.date DESC"; // Изменение сортировки на убывающую дату
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':parentCommentID', $parentCommentID, PDO::PARAM_INT);
        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reply = array(
                'commentID' => $row['commentID'],
                'userID' => $row['userID'],
                'username' => $row['username'],
                'comment' => $row['comment'],
                'date' => $row['date']
            );

            $replies[] = $reply;

            // Рекурсивно вызываем эту функцию для поиска ответов на этот ответ
            $this->getRepliesRecursive($row['commentID'], $replies);
        }
    }  
    
    // метод для получения имени пользователя оригинального комментария
    public function getUsernameForOriginalComment($commentID) {
        $query = "SELECT u.username 
                FROM user u 
                JOIN comments c ON u.userID = c.userID 
                WHERE c.commentID = (
                    SELECT parent_comment_id 
                    FROM comments 
                    WHERE commentID = :commentID
                )";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':commentID', $commentID);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['username'];
    }

    // метод для получения ID пользователя оригинального комментария
    public function getUserIDForOriginalComment($parentCommentID) {
        $query = "SELECT c.userID 
                FROM comments c 
                WHERE c.commentID = :parentCommentID";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':parentCommentID', $parentCommentID);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['userID'];
    }
    

    public function getUsernameByUserID($userID) {
        $query = "SELECT username FROM user WHERE userID = :userID";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userID', $userID);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['username'];
    }
    
    
}
