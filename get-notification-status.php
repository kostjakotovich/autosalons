<?php
session_start();
require_once 'connection.php';

if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];
    $conn = (new Database())->connect();

    // Выполните запрос, чтобы проверить статус уведомлений пользователя
    $sql = "SELECT COUNT(*) as unread_count FROM notifications WHERE userID = :userID AND is_read = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $unreadCount = $result['unread_count'];

        if ($unreadCount > 0) {
            // У пользователя есть непрочитанные уведомления
            echo 'unread';
        } else {
            // Все уведомления прочитаны
            echo 'read';
        }
        
        
    } else {
        // Ошибка при выполнении запроса
        echo 'error';
    }
} else {
    // Пользователь не авторизован
    echo 'invalid';
}
?>
