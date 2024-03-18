<?php
session_start();
require_once 'connection.php';

if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];
    $conn = (new Database())->connect();

    // Обновляем статус прочтения уведомлений для всех топиков пользователя
    $sql = "UPDATE `notifications` 
            SET `is_read` = 1 
            WHERE `topic_id` IN (SELECT `topic_id` 
                                 FROM `notification_topics` 
                                 WHERE `userID` = :userID)";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Успешно обновлено
        echo 'success';
    } else {
        // Ошибка при обновлении
        echo 'error';
    }
} else {
    // Пользователь не авторизован
    echo 'invalid';
}
?>
