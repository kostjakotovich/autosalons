<?php
session_start();
require_once 'connection.php';
require_once 'Offer.php';
require_once 'User.php';
require_once 'Order.php';


$offerID = isset($_GET['offerID']);
if (isset($_GET['offerID'])) {
  $offerID = $_GET['offerID'];
  $offer = new Offer();
  $selectedOffer = $offer->getOffer($offerID);
  $selectedOfferInfo = $offer->getOfferInfo($offerID);
} 


if (isset($_SESSION['success'])) {
  // Create an Order object with offerID and userID
  $order = new Order($offerID, $_SESSION['userID']);

  // Check if the user has any "New" or "In progress" orders
  $hasActiveOrders = $order->checkOrdersStatus();
}

if (isset($_POST['submit_order'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $telephone = $_POST['telephone'];
    echo "<script>event.preventDefault();</script>";
    if (isset($_SESSION['userID'])) {
        $order = new Order();
        $order->createOrder($_POST['name'], $_POST['surname'], $_POST['telephone'], $_POST['offerID']);
    } else {
      // Handle the case where the user is not logged in
    }
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
<div class="container2">
  <img src="<?php echo $selectedOffer['image']; ?>" style="float:left">
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
            if ($hasActiveOrders) {
                ?>
                <p class="btn">Wait for a response to Your previous order.</p>
                <?php
            } else {
                ?>
                <input type="button" value="Get an offer" class="btn2" onclick="on()"></input>
                <?php
            }
          } else {
              ?>
              <p class="btn">You need to log in to make an offer.</p>
              <?php
          }
              
      ?>
    </div>
  </div>
</div>

    <div id="overlay" onclick="off()">
      <div id="text" class="form-container">
        <form method="post" action="offerPage.php">

          <input type="hidden" name="offerID" value="<?php echo $selectedOffer['offerID'] ?>">

          <div class="form-group2">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" maxlength="20" required>
          </div>
          <div class="form-group2">
            <label for="surname">Surname:</label>
            <input type="text" class="form-control" id="surname" name="surname" maxlength="20" required>
          </div>
          <div class="form-group2">
            <label for="telephone">Telephone:</label>
            <input type="text" class="form-control" id="telephone" name="telephone" maxlength="20" required>
          </div>
          <br>
          <input type="submit" name="submit_order" value="Submit" class="btn btn-primary">

          <input type="button" value="Cancel" onclick="off(event)" id="cancelButton" class="btn btn-primary">

        </form>
      </div>
    </div>
  
<?php include 'footer.php'; ?>
</body>

</html>