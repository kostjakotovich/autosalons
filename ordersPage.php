<?php
session_start();
require_once 'connection.php';
require_once 'Order.php';
require_once 'User.php';


// Создаем объект пользователя, чтобы получить информацию о роли
$user = new UserMain($_SESSION['userID']);
$userInfo = $user->getUserInfo();

// Проверяем, является ли пользователь администратором
if ($_SESSION['roleID'] !== 1) {
    // Если нет, то перенаправляем на главную страницу
    header('Location: index.php');
    exit();
}

// Создаем объект заказа
$order = new Order(); // второй параметр - userID - не важен, т.к. будет устанавливаться внутри цикла

// Получаем информацию о всех заказах
$orders = $order->getAllOrderInfo();

if (isset($_POST['submit'])) {
    if (empty($status)) {
        foreach ($_POST['status'] as $orderID => $status) {
            // Обновляем статус заказа по его ID
            $order = new Order();
            $order->updateStatus($status, $orderID);

            // Перезагружаем информацию о заказах из базы данных
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
  <!-- Bootstrap JS -->
  <script src="bootstrap-5.1.3-dist\js\bootstrap.min.js"></script>
  <script src="js/order-success-close.js" defer></script>
  <link rel="stylesheet" href="css/orders.css">
</head>
<body>
    <?php require 'header.php';?>

    <div>
    
        <?php 
        if(isset($_SESSION['order_status_success'])){
        ?>
        <div class="alert alert-success text-center" role="alert">
            <?php echo $_SESSION['order_status_success']; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php
        
        unset($_SESSION['order_status_success']);
        }
        ?>

    </div>

    <div style="float:right;">
            <form method="post" action="includes/exportTable.inc.php" >
                <input type="submit" name="export" value="Export to Excel" class="btn">
                <input type="hidden" name="export" value="true">
                <!-- Передаёт информацию о заказах как сериализованный массив -->
                <input type="hidden" name="orders_data" value="<?php echo htmlentities(serialize($orders)); ?>">
            </form>
    </div>
    <br><br>
    <div id="container">
        <form method="post">
            <br>
            <input type="submit" name="submit" value="Save changes" class="btn">
            <br><br><br><br>
            <!-- Таблица для заказов со статусом New -->
            <br>
            <p>New</p>
            <table>
                <?php include 'includes/ordersTableTemplate.php'; ?>
                <tbody>
                    <?php 
                    foreach($newOrders as $order){
                        include 'includes/ordersTable.inc.php';
                    }
                    ?>
                </tbody>
            </table>

            <!-- Таблица для заказов со статусом In progress -->
            <br>
            <br>
            <p>In progress</p>
            <table>
                <?php include 'includes/ordersTableTemplate.php'; ?>
                <tbody>
                    <?php 
                    foreach($inProgressOrders as $order){
                        include 'includes/ordersTable.inc.php';
                    }
                    ?>
                </tbody>
            </table>
            <!-- Таблица для заказов со статусом Done -->
            <br>
            <br>
            <p>Done</p>
            <table>
                <?php include 'includes/ordersTableTemplate.php'; ?>
                <tbody>
                    <?php 
                    foreach($doneOrders as $order){
                        include 'includes/ordersTable.inc.php';
                    }
                    ?>
                </tbody>
            </table>

        </form>
    </div>




    <?php 
        $user = new UserMain($_SESSION['userID']);
        $userInfo = $user->getUserInfo();

    ?>

<?php include 'footer.php'; ?>
</body>
</html>
