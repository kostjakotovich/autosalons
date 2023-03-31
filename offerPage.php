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
  <script src="../autosalons/js/script.js" defer></script>
  <script src="../autosalons/js/form-popup.js" defer></script>
  <link rel="stylesheet" href="css/offerPage.css">
</head>
<body>
<?php require 'header.php'; ?>
<img src="img/<?php echo $selectedOffer['image']; ?>.webp" alt="Car Image" style="float:left">
<div class="card">
  <div class="card-body">
    <h5 class="card-title"><?php echo $selectedOffer['manufacturer'] . ' ' . $selectedOffer['type']; ?></h5>
    <br>
    <br>
    <h5>More information:</h5>
    <br>
    <p class="card-text"><?php echo 'Color: ' .$selectedOfferInfo['color'] ; ?></p>
    <p class="card-text"><?php echo 'Price: ' . $selectedOfferInfo['price'] . ' €'; ?></p>
    <p class="card-text"><?php echo 'Year Of Manufacture: ' . date('Y', strtotime($selectedOfferInfo['yearOfManufacture'])); ?></p>
    <p class="card-text"><?php echo 'Weight: ' . $selectedOfferInfo['weight'] . ' kg'; ?></p>
    <?php 
        if (isset($_SESSION['success'])) {
          ?> <a href="#" class="btn" onclick="on()">Get an offer</a>
        <?php } 
        else{
          ?> <p class="btn">You need to log in to make an offer.</p>
        <?php } ?>
  </div>
</div>

    <div id="overlay" onclick="off()">
      <div id="text">
      <form method="post" action="Order.php">
          <label for="name">Name:</label><br>
          <input type="text" id="name" name="name" required><br>
          <label for="surname">Surname:</label><br>
          <input type="text" id="surname" name="surname" required><br>
          <label for="telephone">Telephone:</label><br>
          <input type="tel" id="telephone" name="telephone" required><br><br>
          <input type="submit" value="Submit" id="submitButton">
          <input type="button" value="Cancel" onclick="off(event)" id="cancelButton">

        </form>
      </div>
    </div>


</body>
</html>