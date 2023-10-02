<?php
session_start();
require_once 'connection.php'; // Подключение к базе данных
require_once 'Offer.php'; // Подключение класса Offer

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Проверяем, был ли отправлен GET-запрос
    if (isset($_GET['offerID']) && isset($_GET['color'])) {
        $offerID = $_GET['offerID'];
        $color = $_GET['color'];

        // Создаем объект класса Offer
        $offer = new Offer();

        // Вызываем метод удаления цвета
        $offer->deleteColor($offerID, $color);

        // Перенаправляем пользователя обратно на страницу предложения
        header('Location: offerPage.php?offerID=' . $offerID);
        exit;
    } else {
        // В случае некорректных данных или ошибки отобразить сообщение об ошибке
        echo "Invalid data.";
    }
} else {
    // Если запрос не является GET-запросом, отобразить сообщение об ошибке
    echo "Invalid request.";
}
?>
