<?php
session_start();
require_once 'connection.php'; // Подключение к базе данных
require_once 'Offer.php'; // Подключение класса Offer

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Проверяем, была ли отправлена форма
    if (isset($_POST['newColor']) && isset($_POST['offerID']) && isset($_FILES['colorImage'])) {
        $newColor = $_POST['newColor'];
        $offerID = $_POST['offerID'];
        
        // Обработка загруженного изображения
        $imageFileName = $_FILES['colorImage']['name'];
        $imageFilePath = '../autosalons/img/' . $imageFileName;
        
        // Переместите загруженное изображение в нужное место на сервере
        move_uploaded_file($_FILES['colorImage']['tmp_name'], $imageFilePath);

        // Создаем объект класса Offer
        $offer = new Offer();

        // Вызываем метод добавления цвета с изображением
        $offer->addColorWithImage($offerID, $newColor, $imageFilePath);

        // Перенаправляем пользователя обратно на страницу предложения
        header('Location: offerPage.php?offerID=' . $offerID);
        exit;
    } else {
        // В случае некорректных данных или ошибки отобразить сообщение об ошибке
        echo "Invalid data.";
    }
} else {
    // Если запрос не является POST-запросом, отобразить сообщение об ошибке
    echo "Invalid request.";
}
?>
