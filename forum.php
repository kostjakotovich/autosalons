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

    <div class="container">
        <div class="card">
            <form method="post">
                <label for="comment">Leave your comment (no more than 250 characters):</label><br>
                <textarea name="comment" id="comment" cols="30" rows="5" maxlength="250"></textarea><br>
                <input type="submit" value="Send comment">
            </form>
        </div>
    </div>

    <div class="comments">
            <?php
            // Отображаем комментарии и имена пользователей
            foreach ($comments as $comment) {
                echo '<div class="comment">';
                echo '<h4>' . $comment['username'] . '</h4>';
                echo '<p>' . $comment['comment'] . '</p><br>';
                echo '<h4>Posted on ' . date('F j, Y', strtotime($comment['date'])) . '</h4>';
                echo '</div>';
            }
            ?>
        </div>

</body>
</html>
