<?php
session_start();
require_once 'connection.php';
require_once 'Offer.php';
require_once 'User.php';
require_once 'Order.php';

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
          ?> <input type="button" value="Get an offer" class="btn2" onclick="on()"></input>
        <?php } 
        else{
          ?> <p class="btn">You need to log in to make an offer.</p>
        <?php } ?>
  </div>
</div>


    <div id="overlay" onclick="off()">
      <div id="text" class="form-container">
        <form method="post" action="offerPage.php">

          <input type="hidden" name="offerID" value="<?php echo $offerID ?>">

          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="form-group">
            <label for="surname">Surname:</label>
            <input type="text" class="form-control" id="surname" name="surname" required>
          </div>
          <div class="form-group">
            <label for="telephone">Telephone:</label>
            <input type="text" class="form-control" id="telephone" name="telephone" required>
          </div>
          <input type="submit" name="submit_order" value="Submit" class="btn btn-primary">

          <input type="button" value="Cancel" onclick="off(event)" id="cancelButton" class="btn btn-primary">

        </form>
      </div>
    </div>
<?php include 'footer.php'; ?>
</body>

</html>