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
  <script src="../autosalons/js/registration.js" defer></script>
  <link rel="stylesheet" href="css/offerPage.css">
</head>
<body>
<?php require 'header.php'; ?>
<img src="img/<?php echo $selectedOffer['image']; ?>.webp" alt="Car Image" style="float:left">
<div class="card">
  <div class="card-body">
    <h5 class="card-title"><?php echo $selectedOffer['manufacturer'] . ' ' . $selectedOffer['type']; ?></h5>
    <p class="card-text"><?php echo 'Color: ' .$selectedOfferInfo['color'] ; ?></p>
    <p class="card-text"><?php echo 'Price: ' . $selectedOfferInfo['price'] . ' €'; ?></p>
    <br>
    <p class="card-text"><?php echo 'Year Of Manufacture: ' . date('Y', strtotime($selectedOfferInfo['yearOfManufacture'])); ?></p>
    <p class="card-text"><?php echo 'Weight: ' . $selectedOfferInfo['weight'] . ' kg'; ?></p>
    <a href="#" class="btn" onclick="on()">Get an offer</a>
  </div>
</div>

    <div id="overlay" onclick="off()">
      <div id="text">
        <form method="post" action="offerPage.php">
          <label for="name">Name:</label><br>
          <input type="text" id="name" name="name" required><br>
          <label for="surname">Surname:</label><br>
          <input type="text" id="surname" name="surname" required><br>
          <label for="telephone">Telephone:</label><br>
          <input type="tel" id="telephone" name="telephone" required><br><br>
          <input type="submit" value="Submit">
          <input type="button" value="Cancel" onclick="off()">
        </form>
      </div>
    </div>

<script>
function on() {
  document.getElementById("overlay").style.display = "block";
}

function off() {
  document.getElementById("overlay").style.display = "none";
}
</script>

</body>
</html>