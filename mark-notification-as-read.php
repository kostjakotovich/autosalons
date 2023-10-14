<?php
session_start();
require_once 'connection.php';

if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];
    $conn = (new Database())->connect();

    // Обновите столбец is_read для всех уведомлений пользователя
    $sql = "UPDATE `notifications` SET `is_read` = 1 WHERE `userID` = :userID";
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
