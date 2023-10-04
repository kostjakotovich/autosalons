<?php
    require_once 'User.php';

    $userID = isset($_SESSION['userID']);
    $user = new UserMain($userID);
    $notifications = $user->getNotifications();
?>

<!-- notification-modal.php -->
<head>
    <link rel="stylesheet" href="css/notification-modal.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simplebar@5.3.0/dist/simplebar.min.css">
    <script src="https://cdn.jsdelivr.net/npm/simplebar@5.3.0/dist/simplebar.min.js"></script>

</head>
<body>

    <!-- notification-modal.php -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="notificationModalLabel">Notifications</h5>
                <button type="button" class="custom-close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <!-- Используем "-" вместо "×" -->
                    <span aria-hidden="true">-</span>
                </button>
            </div>
            <div class="modal-body simplebar">
                <!-- Здесь будет содержимое модального окна с уведомлениями -->
                <?php
                if ($notifications) {
                    foreach ($notifications as $notification) {
                        $notificationID = $notification['notification_id'];
                        $message = htmlspecialchars_decode($notification['message']);
                        echo "<form method='post' action='includes/delete-notification-modal.php' class='notification-form'>";
                        echo "<div class='notification'>";
                        echo "<button type='submit' class='delete-btn' name='notificationID' value='$notificationID'>✖</button>";
                        echo "<p>$message</p>";
                        echo "</div>";
                        echo "</form>";
                    }
                } else {
                    echo "<div class='notification empty-notification' style='text-align:center;'>Empty</div>";
                }                
                ?>

            </div>
        </div>
    </div>
</div>


</body>

