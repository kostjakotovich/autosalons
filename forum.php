<?php
session_start();
require_once 'connection.php';
require_once 'User.php';
require_once 'Comment.php';

$commentObj = new Comment();

// Определяем количество комментариев на странице
$commentsPerPage = 7;

$startIndex = 0;
$endIndex = $startIndex + $commentsPerPage;
// Определяем общее количество страниц, которые будут отображаться

$totalComments = $commentObj->getTotalCommentsCount();
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

// Проверяем, является ли текущая страница последней
if ($currentPage == $totalPages) {
    // Вычисляем количество комментариев на последней странице
    $commentsOnLastPage = $totalComments - ($totalPages - 1) * $commentsPerPage;
    // Изменяем переменную $endIndex, чтобы отобразить только необходимое количество комментариев на последней странице
    $endIndex = $startIndex + $commentsOnLastPage;
}

// Получаем комментарии для текущей страницы
$comments = $commentObj->getCommentsForPage($startIndex, $commentsPerPage);


// Обработка формы для добавления нового комментария
if (isset($_POST['comment'])) {
    $comment = $_POST['comment'];
    $userID = $_SESSION['userID'];
    $commentObj->addComment($comment, $userID);
    header("Location: forum.php"); // перезагрузка страницы для избежания повторной отправки формы
    exit;
}

// Получение ID с комментраия, для его удаления
if (isset($_POST['delete'])) {
    $commentID = $_POST['commentID'];
    $commentObj->deleteComment($commentID);
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
        foreach ($comments as $comment) {
            echo '<div class="comment">';
            echo '<h4>' . $comment['username'] . '</h4>';
            echo '<p>' . $comment['comment'] . '</p><br>';
            echo '<h4>Posted on ' . date('F j, Y', strtotime($comment['date'])) . '</h4>';
            if (isset($_SESSION['userID']) && $_SESSION['roleID'] == 0 && $_SESSION['userID'] == $comment['userID']) {
                echo '<div class="card2">';
                echo '  <form method="post">';
                echo '      <input type="hidden" name="commentID" value="' . $comment['commentID'] . '">';
                echo '      <input type="submit" value="Delete" name="delete">';
                echo '  </form>';
                echo '</div>';
            }

            if (isset($_SESSION['roleID']) && $_SESSION['roleID'] == 1) {
                echo '<div class="card2">';
                echo '  <form method="post">';
                echo '      <input type="hidden" name="commentID" value="' . $comment['commentID'] . '">';
                echo '      <input type="submit" value="Delete" name="delete">';
                echo '  </form>';
                echo '</div>';
            }

            echo '</div>';
        }
    ?>
</div>



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


</body>
</html>
