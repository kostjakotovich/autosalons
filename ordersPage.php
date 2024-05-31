<?php
session_start();
require_once 'connection.php';
require_once 'Order.php';
require_once 'User.php';

$user = new UserMain($_SESSION['userID']);
$userInfo = $user->getUserInfo();

if ($_SESSION['roleID'] !== 1) {
    header('Location: index.php');
    exit();
}

$order = new Order();

$orders = $order->getAllOrderInfo();

if (isset($_POST['submit'])) {
    if (empty($status)) {
        foreach ($_POST['status'] as $orderID => $status) {
            $order = new Order();
            $order->updateStatus($status, $orderID);

            $orders = $order->getAllOrderInfo();
            
        }
    }
}

$newOrders = array();
$inProgressOrders = array();
$doneOrders = array();

foreach($orders as $order){
    if($order['status'] == 'New'){
        array_push($newOrders, $order);
    }
    elseif($order['status'] == 'In progress'){
        array_push($inProgressOrders, $order);
    }
    elseif($order['status'] == 'Done'){
        array_push($doneOrders, $order);
    }
}

if (isset($_POST['deleteOrder'])) {
    $order = new Order();
    $order->deleteOrder($_POST['orderID']);
}

?>

<html>
<head>
  <script src="js/order-success-close.js" defer></script>
  <link rel="stylesheet" href="css/orders.css">
</head>
<body>
    <?php require 'header.php';?>

    <div>
        <?php if(isset($_SESSION['order_status_success'])): ?>
        <div class="alert alert-success text-center" role="alert">
            <?php echo $_SESSION['order_status_success']; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php unset($_SESSION['order_status_success']); ?>
        <?php endif; ?>
    </div>

    <div style="float:right; margin-top: 1%; margin-right: 1%;">
        <form method="post" action="includes/exportTable.inc.php">
            <input type="submit" name="export" value="Export to Excel" class="btn">
            <input type="hidden" name="export" value="true">
            <input type="hidden" name="orders_data" value="<?php echo htmlentities(serialize($orders)); ?>">
        </form>
        <div class="order-divider"></div>
    </div>
    <br><br>
    <div id="container">
        <form method="post">
            <br>
            <input type="submit" name="submit" value="Save changes" class="btn">
            <div class="settings-tabs">
                <button id="newTab" class="setTabButton" onclick="showTab('new', event)">New</button>
                <button id="inProgressTab" class="setTabButton" onclick="showTab('inProgress', event)">In Progress</button>
                <button id="doneTab" class="setTabButton" onclick="showTab('done', event)">Done</button>
            </div>

            <div class="order-divider2"></div>

            <div id="newTable" class="tabContent">
                <br><br>
                <p>New</p>
                <table>
                    <?php include 'includes/ordersTableTemplate.php'; ?>
                    <tbody>
                        <?php foreach($newOrders as $order): ?>
                            <?php include 'includes/ordersTable.inc.php'; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div id="inProgressTable" class="tabContent">
                <br>
                <br>
                <p>In progress</p>
                <table>
                    <?php include 'includes/ordersTableTemplate.php'; ?>
                    <tbody>
                        <?php foreach($inProgressOrders as $order): ?>
                            <?php include 'includes/ordersTable.inc.php'; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div id="doneTable" class="tabContent">
                <br>
                <br>
                <p>Done</p>
                <table>
                    <?php include 'includes/ordersTableTemplate.php'; ?>
                    <tbody>
                        <?php foreach($doneOrders as $order): ?>
                            <?php include 'includes/ordersTable.inc.php'; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </form>
    </div>

    <script>
        function showTab(tabName, event) {
            event.preventDefault();
            // Hide all tab contents
            const tabs = document.querySelectorAll('.tabContent');
            tabs.forEach(tab => {
                tab.style.display = 'none';
            });

            const tabButtons = document.querySelectorAll('.setTabButton');
            tabButtons.forEach(button => {
                button.classList.remove('activeSetTab');
            });

            document.getElementById(tabName + 'Table').style.display = 'block';

            event.currentTarget.classList.add('activeSetTab');
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('newTab').click();
        });
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>


<style>
    .setTabButton {
        background-color: #f2f2f2;
        border: none;
        color: #333;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 5px;
        outline: none; 
    }

    .activeSetTab {
        background-color: #007bff;
        color: #fff;
    }

    .settings-tabs {
        margin-top: 2%;
    }

    .tabContent {
        display: none;
    }

    .tabContent.active {
        display: block;
    }

</style>