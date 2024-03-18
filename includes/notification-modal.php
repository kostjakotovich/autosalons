<?php
require_once 'User.php';

if (isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];
    $user = new UserMain($userID);
    $notifications = $user->getNotifications();

    $forumTopicID = $user->getNotificationTopicIDByName('Forum');
    $ordersTopicID = $user->getNotificationTopicIDByName('Orders');
    $profileTopicID = $user->getNotificationTopicIDByName('Profile');

    $forumStatus = $user->getNotificationTopicStatus($forumTopicID);
    $ordersStatus = $user->getNotificationTopicStatus($ordersTopicID);
    $profileStatus = $user->getNotificationTopicStatus($profileTopicID);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['updateFilter'])) {
        if (isset($_POST['forum']) && isset($_POST['orders']) && isset($_POST['profile'])) {
            $forumStatus = $_POST['forum'] === 'disable' ? 'disable' : 'enable';
            $ordersStatus = $_POST['orders'] === 'disable' ? 'disable' : 'enable';
            $profileStatus = $_POST['profile'] === 'disable' ? 'disable' : 'enable';

            // Обновление статуса уведомлений
            $user->updateNotificationTopicStatus($forumTopicID, $forumStatus);
            $user->updateNotificationTopicStatus($ordersTopicID, $ordersStatus);
            $user->updateNotificationTopicStatus($profileTopicID, $profileStatus);

            ?><script>
                 window.location.href = window.location.href;
            </script><?php
        }
    }
}
?>

<link rel="stylesheet" href="css/notification-modal.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simplebar@5.3.0/dist/simplebar.min.css">
<script src="https://cdn.jsdelivr.net/npm/simplebar@5.3.0/dist/simplebar.min.js"></script>

<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="notificationModalLabel">Notifications</h5>
                <button type="button" class="custom-close-btn" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">-</span>
                </button>
            </div>
            <div class="modal-body simplebar">
                <div class="settings-header">
                    <form method="post">
                        <div class="filter-options">
                            <div class="filter-item">
                                <label for="forumFilter">Forum:</label>
                                <select id="forumFilter" name="forum">
                                    <option value="enable" <?php echo $forumStatus === 'enable' ? 'selected' : ''; ?>>Show</option>
                                    <option value="disable" <?php echo $forumStatus === 'disable' ? 'selected' : ''; ?>>Hide</option>
                                </select>
                            </div>
                            <div class="filter-item">
                                <label for="ordersFilter">Orders:</label>
                                <select id="ordersFilter" name="orders">
                                    <option value="enable" <?php echo $ordersStatus === 'enable' ? 'selected' : ''; ?>>Show</option>
                                    <option value="disable" <?php echo $ordersStatus === 'disable' ? 'selected' : ''; ?>>Hide</option>
                                </select>
                            </div>
                            <div class="filter-item">
                                <label for="profileFilter">Profile:</label>
                                <select id="profileFilter" name="profile">
                                    <option value="enable" <?php echo $profileStatus === 'enable' ? 'selected' : ''; ?>>Show</option>
                                    <option value="disable" <?php echo $profileStatus === 'disable' ? 'selected' : ''; ?>>Hide</option>
                                </select>
                            </div>
                            <div class="button-container">
                                <button type="submit" class="save-button" name="updateFilter">Save</button>
                            </div>
                        </div>
                    </form>
                    <div class="clear-container">
                        <form method="post" action="includes/delete-all-notifications.php" style="display: inline-block;">
                            <input type="hidden" name="userID" value="<?php echo $userID; ?>">
                            <button type="submit" class="clear-button">Clear all</button>
                        </form>
                    </div>
                </div>

                <div class="comment-divider"></div>

                <?php
                if ($notifications) {
                    foreach ($notifications as $notification) {
                        $notificationID = $notification['notification_id'];
                        $message = htmlspecialchars_decode($notification['message']);
                        $topicName = $notification['topic_name'];
                        $notificationTime = $notification['created_at'];
                        $formattedTime = date('g:i a, F j, Y', strtotime($notificationTime));
                ?>
                        <form method='post' action='includes/delete-notification-modal.php' class='notification-form'>
                            <div class='notification'>
                                <div class='topic-name'><h6><?php echo $topicName; ?></h6></div>
                                <button type='submit' class='delete-btn' name='notificationID' value='<?php echo $notificationID; ?>'>❌</button>
                                <div class='notification-time'><?php echo $formattedTime; ?></div>
                                <div class="notification-divider"></div>
                                <div class='notification-text'><p><?php echo $message; ?></p></div>
                            </div>
                        </form>
                <?php
                    }                    
                } else {
                    echo "<div class='notification empty-notification' style='text-align:center;'>Empty</div>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

