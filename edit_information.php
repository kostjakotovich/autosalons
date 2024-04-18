<?php
session_start();

require_once 'connection.php';
require_once 'Offer.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type = isset($_POST['type']) ? $_POST['type'] : null;
    $manufacturer = isset($_POST['manufacturer']) ? $_POST['manufacturer'] : null;
    $color = isset($_POST['color']) ? $_POST['color'] : null;
    $color_price = isset($_POST['color_price']) ? $_POST['color_price'] : null;
    $price = isset($_POST['price']) ? $_POST['price'] : null;
    $weight = isset($_POST['weight']) ? $_POST['weight'] : null;
    $yearOfManufacture = isset($_POST['yearOfManufacture']) ? $_POST['yearOfManufacture'] : null;
    $offerID = $_POST['offerID'];

    if (empty($type) && empty($manufacturer) && empty($color) && empty($color_price) && empty($price) && empty($weight) && empty($yearOfManufacture)) {
        echo "<script>
                window.history.back();
              </script>";
        exit();
    }    

    if ($_FILES['car_image']['error'] === UPLOAD_ERR_OK) {
        $imageFileName = $_FILES['car_image']['name'];
        $imageFilePath = '../autosalons/img/' . $imageFileName;
        move_uploaded_file($_FILES['car_image']['tmp_name'], $imageFilePath);
    } else {
        $offer = new Offer();
        $existingOffer = $offer->getOffer($offerID);
        $imageFilePath = isset($existingOffer['image']) ? $existingOffer['image'] : null;
    }

    $offer = new Offer();
    $currentOfferInfo = $offer->getOffer($offerID);

    $updatedData = [
        'type' => $type ?? $currentOfferInfo['type'],
        'manufacturer' => $manufacturer ?? $currentOfferInfo['manufacturer'],
        'color' => $color ?? $currentOfferInfo['color'],
        'color_price' => $color_price ?? $currentOfferInfo['color_price'],
        'price' => $price ?? $currentOfferInfo['price'],
        'weight' => $weight ?? $currentOfferInfo['weight'],
        'yearOfManufacture' => $yearOfManufacture ?? $currentOfferInfo['yearOfManufacture']
    ];

    $result = $offer->updateOfferInformation($offerID, $updatedData['type'], $updatedData['manufacturer'], $updatedData['color'], $updatedData['color_price'], $updatedData['price'], $updatedData['weight'], $updatedData['yearOfManufacture'], $imageFilePath);

    if ($result) {
        header("Location: offerPage.php?offerID=$offerID");
        exit();
    } else {
        echo "Error updating offer information.";
    }
}
?>
