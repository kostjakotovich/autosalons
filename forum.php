<?php
    session_start();
    require_once 'connection.php';
    require_once 'User.php';
    require_once 'Comment.php';

    if (!isset($_SESSION['userID'])) {
        header("Location: login.php");
        exit();
    }

    $commentObj = new Comment();

    // Определяем количество комментариев на странице
    $commentsPerPage = 7;

    $startIndex = 0;
    $endIndex = $startIndex + $commentsPerPage;
    // Определяем общее количество страниц, которые будут отображаться

    $totalComments = $commentObj->getTotalOriginalCommentsCount();
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
    $comments = $commentObj->getOriginalCommentsForPage($startIndex, $commentsPerPage);

    // Обработка формы для добавления нового комментария
    if (isset($_POST['comment'])) {
        $comment = $_POST['comment'];
        $userID = $_SESSION['userID'];
        $commentObj->addComment($comment, $userID);
        header("Location: forum.php"); // перезагрузка страницы для избежания повторной отправки формы
        exit;
    }

    // Получение ID с комментария для его удаления
    if (isset($_POST['delete'])) {
        $commentID = $_POST['commentID'];
        $commentObj->deleteComment($commentID);
        header("Location: forum.php"); // перезагрузка страницы для избежания повторной отправки формы
        exit;
    }

    // Получение ID комментария для ответа
    if (isset($_POST['reply'])) {
        $reply = $_POST['reply'];
        $userID = $_SESSION['userID'];
        $commentID = $_POST['parentCommentID']; // Используем parentCommentID
        $commentObj->addReply($reply, $userID, $commentID);
        header("Location: forum.php"); // перезагрузка страницы для избежания повторной отправки формы
        exit;
    }

    $userObj = new UserMain($_SESSION['userID']);

    if (!$userObj->isRulesAccepted()) {
        include 'includes\rules_modal.php';
    }   

    if (isset($_POST['accept_rules'])) {
        $userID = $_SESSION['userID'];
        $userObj = new UserMain($userID);
        $userObj->acceptRules();
        
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

?>

<html>
<head>
    <!-- style css links -->
    <link rel="stylesheet" href="css/forum.css">
    <link rel="stylesheet" href="css/rules_modal.css">
</head>
<body>
    <?php require 'header.php'; ?>

    <div class="box">
        <div class="container-comment">
            <div class="card">
                <form method="post">
                    <label for="comment">Leave your comment (no more than 700 characters):</label><br>
                    <textarea name="comment" id="comment" cols="30" rows="5" maxlength="700" required></textarea><br>
                    <input type="submit" value="Send comment">
                </form>
            </div>
        </div>

        <div class="comments">
            <?php foreach ($comments as $comment) { ?>
                <div class="comment">
                    <div class="user-info">
                        <div class="avatar">
                            <img src="<?php echo $comment['picture']; ?>" alt="profile pic" class="avatar-img">
                        </div>
                        <h4><?php echo $comment['username']; ?></h4>
                    </div>
                        <div class="comment-divider"></div>
                        <p><?php echo $comment['comment']; ?></p><br>
                        <h4>Posted at <?php echo date('g:i a, F j, Y', strtotime($comment['date'])); ?></h4>

                    <div class="button-group">
                        <button class="reply-btn">Reply</button>
                        <?php if (isset($_SESSION['userID']) && ($_SESSION['roleID'] == 0 && $_SESSION['userID'] == $comment['userID']) || $_SESSION['roleID'] == 1) { ?>
                            <div class="card2">
                                <form method="post">
                                    <input type="hidden" name="commentID" value="<?php echo $comment['commentID']; ?>">
                                    <input type="submit" class="btn-delete" value="Delete" name="delete">
                                </form>
                            </div>
                        <?php } ?>
                    </div>
                    <!-- Форма для ответа на комментарий -->
                    <div class="reply-form" style="display: none;">
                        <form method="post">
                            <input type="hidden" name="parentCommentID" value="<?php echo $comment['commentID']; ?>">
                            <label for="reply_<?php echo $comment['commentID']; ?>">Your reply:</label><br>
                            <textarea name="reply" id="reply_<?php echo $comment['commentID']; ?>" cols="30" rows="3" maxlength="700" required></textarea><br>
                            <input class="send_reply_button" type="submit" value="Send reply">
                        </form>
                    </div>
                </div>

                    <!-- Показывать ответы только при наличии -->
                    <?php $replies = $commentObj->getRepliesForComment($comment['commentID']); ?>
                    <?php if (!empty($replies)) { ?>
                        <button class="show-replies-btn" data-comment-id="<?php echo $comment['commentID']; ?>">Show Replies (<?php echo count($replies); ?>)</button>
                        <div class="replies" style="display: none;">
                            <?php foreach ($replies as $reply) { ?>
                                <div class="reply-comment">
                                    <div class="reply-container">
                                        <div class="reply">
                                            <div class="reply-header">
                                                <div class="avatar">
                                                    <img src="<?php echo $reply['picture']; ?>" alt="profile pic" class="avatar-img">
                                                </div>
                                                <div class="reply-username">
                                                    <h4><?php echo $reply['username']; ?></h4>
                                                </div>
                                                <div class="reply-info">
                                                    <p>Reply to: <strong><?php echo $commentObj->getUsernameForOriginalComment($reply['commentID']); ?></strong></p>
                                                </div>
                                            </div>

                                            <div class="comment-divider"></div>
                                            <p class="reply-comment-text"><?php echo $reply['comment']; ?></p>
                                            <br>
                                            <h4 class="reply-date">Posted at <?php echo date('g:i a, F j, Y', strtotime($reply['date'])); ?></h4>
                                            <div class="button-group">
                                                <button class="reply-btn">Reply</button>
                                                <?php if (isset($_SESSION['userID']) && ($_SESSION['roleID'] == 0 && $_SESSION['userID'] == $reply['userID']) || $_SESSION['roleID'] == 1) { ?>
                                                    <div class="card2">
                                                        <form method="post">
                                                            <input type="hidden" name="commentID" value="<?php echo $reply['commentID']; ?>">
                                                            <input type="submit" class="btn-delete" value="Delete" name="delete">
                                                        </form>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <!-- Форма для ответа на комментарий -->
                                            <div class="reply-form" style="display: none;">
                                                <form method="post">
                                                    <input type="hidden" name="parentCommentID" value="<?php echo $reply['commentID']; ?>"> 
                                                    <label for="reply_<?php echo $comment['commentID']; ?>">Your reply:</label><br>
                                                    <textarea name="reply" id="reply_<?php echo $comment['commentID']; ?>" cols="30" rows="3" maxlength="700" required></textarea><br>
                                                    <input class="send_reply_button" type="submit" value="Send reply">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                
            <?php } ?>

            <script>
                // JavaScript для управления отображением формы ответа и ответов
                document.querySelectorAll('.reply-btn').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        var parentContainer = this.parentNode.parentNode;
                        var replyForm = parentContainer.querySelector('.reply-form');
                        if (replyForm) {
                            replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
                        }
                    });
                });

                document.querySelectorAll('.show-replies-btn').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        var repliesContainer = this.nextElementSibling;
                        if (repliesContainer) {
                            repliesContainer.style.display = repliesContainer.style.display === 'none' ? 'block' : 'none';
                            this.textContent = repliesContainer.style.display === 'none' ? 'Show Replies (' + repliesContainer.querySelectorAll('.reply-comment').length + ')' : 'Hide Replies';
                        }
                    });
                });
            </script>


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
    </div>
    <?php include 'footer.php'; ?>
    
    <script src="js/rules_modal.js"></script>
</body>
</html>
