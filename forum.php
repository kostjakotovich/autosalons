<?php
session_start();
require_once 'connection.php';
require_once 'User.php';
require_once 'Comment.php';

$commentObj = new Comment();

// Определяем количество комментариев на странице
$commentsPerPage = 7;

// Получаем общее количество комментариев из базы данных
$totalComments = $commentObj->getTotalCommentsCount();

// Определяем общее количество страниц, которые будут отображаться
$totalPages = ceil($totalComments / $commentsPerPage);

// Получаем текущую страницу из параметров URL
if (isset($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1;
}

// Определяем начальный и конечный индексы для отображаемых комментариев
$startIndex = ($currentPage - 1) * $commentsPerPage;
$endIndex = $startIndex + $commentsPerPage;

// Получаем комментарии для текущей страницы
$comments = $commentObj->getCommentsForPage($startIndex, $endIndex);

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

        <div class="pagination">
            <?php
            // Отображаем ссылки на страницы
            for ($i = 1; $i <= $totalPages; $i++) {
                if ($i == $currentPage) {
                    echo '<a href="#" class="active">' . $i . '</a>';
                } else {
                    echo '<a href="forum.php?page=' . $i . '">' . $i . '</a>';
                }
            }
            ?>
        </div>
    </div>

</body>
</html>
