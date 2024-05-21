<?php
session_start();

require_once 'connection.php';
require_once 'Offer.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = isset($_POST['type']) ? $_POST['type'] : null;
    $manufacturer = isset($_POST['manufacturer']) ? $_POST['manufacturer'] : null;
    $body_type = isset($_POST['body_type']) ? $_POST['body_type'] : null;
    $transmission_type = isset($_POST['transmission_type']) ? $_POST['transmission_type'] : null;
    $transmission_price = isset($_POST['transmission_price']) ? $_POST['transmission_price'] : null;
    $engine_type = isset($_POST['engine_type']) ? $_POST['engine_type'] : null;
    $engine_price = isset($_POST['engine_price']) ? $_POST['engine_price'] : null;
    $color = isset($_POST['color']) ? $_POST['color'] : null;
    $color_price = isset($_POST['color_price']) ? $_POST['color_price'] : null;
    $price = isset($_POST['price']) ? $_POST['price'] : null;
    $weight = isset($_POST['weight']) ? $_POST['weight'] : null;
    $yearOfManufacture = isset($_POST['yearOfManufacture']) ? $_POST['yearOfManufacture'] : null;
    $offerID = $_POST['offerID'];
    $detailsID = $_POST['detailsID'];

    if (empty($type) && empty($manufacturer) && empty($body_type) && empty($transmission_type) && empty($transmission_price) && empty($engine_type) && empty($engine_price) && empty($color) && empty($color_price) && empty($price) && empty($weight) && empty($yearOfManufacture)) {
        echo "<script>
                window.history.back();
              </script>";
        exit();
    }    

    if ($_FILES['car_image']['error'] === UPLOAD_ERR_OK) {
        $imageFileName = $_FILES['car_image']['name'];
        $imageFilePath = 'img/' . $imageFileName;
        move_uploaded_file($_FILES['car_image']['tmp_name'], $imageFilePath);
    } else {
        $imageFilePath = null;
    }

    $offer = new Offer();
    $currentOfferInfo = $offer->getOffer($offerID);

    $updatedData = [
        'type' => $type ?? $currentOfferInfo['type'],
        'manufacturer' => $manufacturer ?? $currentOfferInfo['manufacturer'],
        'body_type' => $body_type ?? $currentOfferInfo['body_type'],
        'transmission_type' => $transmission_type ?? $currentOfferInfo['transmission_type'],
        'transmission_price' => $transmission_price ?? $currentOfferInfo['transmission_price'],
        'engine_type' => $engine_type ?? $currentOfferInfo['engine_type'],
        'engine_price' => $engine_price ?? $currentOfferInfo['engine_price'],
        'color' => $color ?? $currentOfferInfo['color'],
        'color_price' => $color_price ?? $currentOfferInfo['color_price'],
        'price' => $price ?? $currentOfferInfo['price'],
        'weight' => $weight ?? $currentOfferInfo['weight'],
        'yearOfManufacture' => $yearOfManufacture ?? $currentOfferInfo['yearOfManufacture']
    ];

    $result = $offer->updateOfferInformation($offerID, $detailsID, $updatedData['type'], $updatedData['manufacturer'], $updatedData['body_type'], $updatedData['transmission_type'], $updatedData['transmission_price'], $updatedData['engine_type'], $updatedData['engine_price'], $updatedData['color'], $updatedData['color_price'], $updatedData['price'], $updatedData['weight'], $updatedData['yearOfManufacture'], $imageFilePath);

    header("Location: offerPage.php?offerID=$offerID&detailsID=$detailsID");
    exit();
}
?>
