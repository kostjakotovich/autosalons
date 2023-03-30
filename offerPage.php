<?php
session_start();
require_once 'connection.php';
require_once 'Offer.php';

if (isset($_GET['offerID'])) {
    $offerID = $_GET['offerID'];
    $offer = new Offer();
    $selectedOffer = $offer->getOffer($offerID);
    $selectedOfferInfo = $offer->getOfferInfo($offerID);
} else {
    header("Location: index.php");
}

?>
<html>
<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="css/cards.css">
  <link rel="stylesheet" href="css/homepage.css">
  <script src="../autosalons/js/script.js" defer></script>
  <script src="../autosalons/js/registration.js" defer></script>
</head>
<body>
<?php require 'header.php'; ?>
<div class="card">
  <img src="img/<?php echo $selectedOffer['image']; ?>.webp" alt="Car Image">
  <div class="card-body">
    <h5 class="card-title"><?php echo $selectedOffer['manufacturer'] . ' ' . $selectedOffer['type']; ?></h5>
    <p class="card-text"><?php echo 'Color: ' .$selectedOfferInfo['color'] ; ?></p>
    <p class="card-text"><?php echo 'Price: ' . $selectedOfferInfo['price'] . ' €'; ?></p>
    <br>
    <p class="card-text"><?php echo 'Year Of Manufacture: ' . $selectedOfferInfo['yearOfManufacture'] ; ?></p>
    <p class="card-text"><?php echo 'Weight: ' . $selectedOfferInfo['weight'] . ' kg'; ?></p>
  </div>
</div>
</body>
</html>