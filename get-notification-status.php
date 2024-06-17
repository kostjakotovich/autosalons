<?php
session_start();
require_once 'connection.php';

if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];
    $conn = (new Database())->connect();

    $sql = "SELECT COUNT(*) as unread_count FROM notifications 
            WHERE topic_id IN (
                SELECT topic_id 
                FROM notification_topics 
                WHERE userID = :userID
            ) AND is_read = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $unreadCount = $result['unread_count'];

        $response = array('status' => ($unreadCount > 0) ? 'unread' : 'read');
        echo json_encode($response);
    } else {
        echo json_encode(array('status' => 'error'));
    }
} else {
    echo json_encode(array('status' => 'invalid'));
}
?>
