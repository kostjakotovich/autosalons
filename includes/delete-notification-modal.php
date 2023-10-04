<?php
    require_once '../User.php';
    if (isset($_POST['notificationID'])) {
        $notificationID = $_POST['notificationID'];
        $userID = isset($_SESSION['userID']);
        $user = new UserMain($userID);
        $user->deleteNotification($notificationID);
    
        // Получаем предыдущий URL
        $previousURL = $_SERVER['HTTP_REFERER'];
    
        // Перенаправляем пользователя обратно на предыдущий URL
        header("Location: $previousURL");
        exit();
    }
    
?>