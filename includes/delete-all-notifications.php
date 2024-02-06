<?php
    require_once '../User.php';

    $userID = isset($_POST['userID']) ? $_POST['userID'] : null; // Получить userID из POST запроса
    
    if ($userID) {
        $user = new UserMain($userID);
        $user->deleteAllNotifications();
    }
    
    $previousURL = $_SERVER['HTTP_REFERER'];
        
    header("Location: $previousURL");
    exit();
    
?>
