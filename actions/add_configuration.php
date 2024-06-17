<?php
session_start();

require_once '../connection.php';
require_once '../Offer.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $color = $_POST['color'];
    $color_price = $_POST['color_price'];
    $transmission_type = $_POST['transmission_type'];
    $transmission_price = $_POST['transmission_price'];
    $engine_type = $_POST['engine_type'];
    $engine_price = $_POST['engine_price'];
    $detailsID = $_POST['detailsID'];
    $offersInfoID = $_POST['offersInfoID'];
    $offerID = $_POST['offerID'];

    $imageFilePath = '';
    if ($_FILES['car_image']['error'] === UPLOAD_ERR_OK) {
        $imageFileName = $_FILES['car_image']['name'];
        $imageFilePath = 'img/' . $imageFileName;
        move_uploaded_file($_FILES['car_image']['tmp_name'], $imageFilePath);
    }

    $offer = new Offer();
    $result = $offer->addConfiguration($detailsID, $offersInfoID, $color, $imageFilePath, $color_price, $transmission_type, $transmission_price, $engine_type, $engine_price);

    if ($result) {
        header("Location: ../offerPage.php?offerID=$offerID&detailsID=$detailsID");
        exit();
    } else {
        echo "Error adding configuration.";
    }
}
?>
