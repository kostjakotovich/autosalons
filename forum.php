<?php
session_start();
require_once 'connection.php';
require_once 'User.php';
require_once 'Comment.php';

$commentObj = new Comment();

// Получаем все комментарии и имена пользователей из таблицы
$comments = $commentObj->getAllComments();

// Обработка формы для добавления нового комментария
if (isset($_POST['comment'])) {
    $comment = $_POST['comment'];
    $userID = $_SESSION['userID'];
    $commentObj->addComment($comment, $userID);
    header("Location: forum.php"); // перезагрузка страницы для избежания повторной отправки формы
    exit;
}
?>

<html>
<head>
    <!-- style css link -->
    <link rel="stylesheet" href="css/forum.css">

</head>
<body>
    <?php require 'header.php'; ?>

    <!-- Форма для добавления нового комментария -->
    <form method="post">
        <label for="comment">Оставьте свой комментарий:</label><br>
        <textarea name="comment" id="comment" cols="30" rows="10"></textarea><br>
        <input type="submit" value="Отправить">
    </form>

    <?php
    // Отображаем комментарии и имена пользователей
    foreach ($comments as $comment) {
        echo '<div>';
        echo '<h4>' . $comment['username'] . ' ' . $comment['date'] . '</h4>';
        echo '<p>' . $comment['comment'] . '</p>';
        echo '</div>';
    }
    ?>

</body>
</html>
