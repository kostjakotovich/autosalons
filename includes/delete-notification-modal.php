<?php
    require_once '../User.php';
    if (isset($_POST['notificationID'])) {
        $notificationID = $_POST['notificationID'];
        $userID = isset($_SESSION['userID']);
        $user = new UserMain($userID);
        $user->deleteNotification($notificationID);
    
        $previousURL = $_SERVER['HTTP_REFERER'];
    
        header("Location: $previousURL");
        exit();
    }
    
?>