<?php
session_start();

require_once 'connection.php';
require_once 'Offer.php';
require_once 'User.php';
require_once 'Order.php';

error_reporting(E_ALL);
ini_set('display_errors', 1); 

if(isset($_SESSION['userID'])) {
  $userID = $_SESSION['userID'];
  $user = new UserMain($userID);
  $userInfo = $user->getUserInfo();
}

$offerID = isset($_GET['offerID']);
if (isset($_GET['offerID'])) {
  $offerID = $_GET['offerID'];
  $detailsID = $_GET['detailsID'];
  $offer = new Offer();
  $offersInfoID = $offer->getOffersInfoID($offerID);
  $isActive = $offer->isOfferActive($detailsID);

  $selectedOffer = $offer->getOffer($offerID);
  $selectedOfferColor = $offer->getOfferColor($offersInfoID, $detailsID);
  $selectedOfferDetails = $offer->getOfferDetails($offersInfoID);
  $selectedOfferTransmission = $offer->getOfferTransmission($offersInfoID, $detailsID);
  $selectedOfferEngine = $offer->getOfferEngine($offersInfoID, $detailsID);
  $selectedOfferInfo = $offer->getOfferInfo($offerID);

  if (isset($_GET['choose_configuration'])) {
    $selectedDetailsID = $_GET['detailsID'];
    $selectedOfferDetails = $offer->getOfferDetailsByID($offersInfoID);
  } else {
    // Если комплектация не выбрана, отображаем предложение по умолчанию
    $selectedDetailsID = null;
    $selectedOfferDetails = $offer->getOfferDetails($offersInfoID); // По умолчанию
  }


  if (isset($_GET['detailsID'])) {
    $selectedDetailsID = $_GET['detailsID'];
    $_SESSION['selectedDetailsID'] = $selectedDetailsID; 
    $selectedOfferDetails = $offer->getOfferDetailsByID($offersInfoID);
} else {
    // Если комплектация не выбрана, отображаем предложение по умолчанию
    $selectedDetailsID = $_SESSION['selectedDetailsID'] ?? null;
    $selectedOfferDetails = $offer->getOfferDetailsByID($offersInfoID);
}

  $carPriceDisplay = $selectedOfferInfo['price'] + $selectedOfferTransmission['transmission_price'] + $selectedOfferColor['color_price'] + $selectedOfferEngine['engine_price'] . ' € ';
} 

if (!isset($_SESSION['roleID']) || $_SESSION['roleID'] == 0){
  if($isActive == 1){
    header("Location: index.php");
  }
}

if (isset($_SESSION['success'])) {
  $order = new Order($offerID, $_SESSION['userID']);

  $hasActiveOrders = $order->checkOrdersStatus();
}

if (isset($_POST['submit_order'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $telephone = $_POST['telephone'];
    $detailsID = $_POST['detailsID'];
    echo "<script>event.preventDefault();</script>";
    if (isset($_SESSION['userID'])) {
        $order = new Order();
        $order->createOrder($_POST['name'], $_POST['surname'], $_POST['telephone'], $_POST['offerID'], $_POST['detailsID']);
    } else {
    
    }
  }

  if (isset($_POST['delete_configuration'])) {
    $detailsID = $_POST['detailsID'];
    $offer = new Offer();
    $result = $offer->deleteConfiguration($detailsID);

    $_SESSION['showError'] = !$result;
    header("Location: offerPage.php?offerID=$offerID&detailsID=$detailsID");
    exit();
}

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["deactivate_offer"])) {
      $result = $offer->deactivateOffer($detailsID);
      header("Location: offerPage.php?offerID=$offerID&detailsID=$detailsID");
    } elseif (isset($_POST["activate_offer"])) {
      $result = $offer->activateOffer($detailsID); 
      header("Location: offerPage.php?offerID=$offerID&detailsID=$detailsID");
    }
  } 

?>
<html>
<head>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
  <script src="../autosalons/js/script.js" defer></script>
  <script src="../autosalons/js/form-popup.js" defer></script>
  <link rel="stylesheet" href="css/offerPage.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

</head>
<body>

<?php require 'header.php'; ?>
<div class="container2">
  <div class="all-information">
    
    <img id="colorImage" src="<?php echo $selectedOfferColor['image']; ?>">

    <div class="card">
      <div class="card-body">
        <div class="main-info">
            <h5 class="card-title"><?php echo $selectedOffer['manufacturer'] . ' ' . $selectedOffer['type']; ?></h5>
            <div class="offer-divider"></div>
            <p class="card-text"><?php echo 'Year Of Manufacture: ' . $selectedOfferInfo['yearOfManufacture']; ?></p>
            <p class="card-text"><?php echo 'Body Type: ' . $selectedOfferInfo['body_type']; ?></p>
            <p class="card-text"><?php echo 'Transmission: ' . $selectedOfferTransmission['transmission_type']; ?></p>
            <p class="card-text"><?php echo 'Engine Type: ' . $selectedOfferEngine['engine_type']; ?></p>
            <p class="card-text"><?php echo 'Weight: ' . $selectedOfferInfo['weight'] . ' kg'; ?></p>
            <p class="card-text"><?php echo 'Color: ' . $selectedOfferColor['color']; ?></p>
            <p class="card-text"><?php echo 'Car Price: ' . $selectedOfferInfo['price'] . ' €'; ?></p>
            <p class="card-text"><?php echo 'Color Price: ' . $selectedOfferColor['color_price'] . ' €'; ?></p>
            <p class="card-text"><?php echo 'Transmission Price: ' . $selectedOfferTransmission['transmission_price'] . ' €'; ?></p>
            <p class="card-text"><?php echo 'Engine Price: ' . $selectedOfferEngine['engine_price'] . ' €'; ?></p>
            <p class="card-text"><?php echo 'Final Price: ' . $carPriceDisplay; ?></p>
        </div>

        <script>
          $(document).ready(function(){
              $('button[name="delete_configuration"]').click(function(e){
                  e.preventDefault(); // Предотвращаем стандартное действие кнопки

                  var form = $(this).closest('form'); // Получаем родительскую форму
                  var detailsID = form.find('input[name="detailsID"]').val(); // Получаем ID деталей
                  var offerID = form.find('input[name="offerID"]').val(); // Получаем ID предложения

                  var deleteConfirmationText = "Are you sure you want to delete this configuration?";
                  swal({
                      title: "Delete Confirmation",
                      text: deleteConfirmationText,
                      icon: "warning",
                      buttons: ["Cancel", "Delete"],
                      dangerMode: true,
                  }).then((willDelete) => {
                      if (willDelete) {
                          $('<input>').attr({
                              type: 'hidden',
                              name: 'delete_configuration',
                              value: true
                          }).appendTo(form);

                          form.unbind('submit').submit();
                      }
                  });
              });
          });
        </script>

        <script>
          <?php if (isset($_SESSION['showError']) && $_SESSION['showError'] === true): ?>
            var errorText = "This record cannot be deleted because there is an order associated with this offer. You can deactivate the offer instead.";
            swal("Error", errorText, "error").then(() => {
              <?php
              unset($_SESSION['showError']);
              ?>
              window.location.href = "offerPage.php?offerID=<?php echo $offerID; ?>&detailsID=<?php echo $detailsID; ?>";
            });
          <?php endif; ?>
        </script>

        <?php 
            if (isset($_SESSION['success'])) {
              if ($hasActiveOrders) {
                  ?>
                  <br>
                  <p class="btn" style="margin-top: -0.5%">Wait for a response to Your previous order.</p>
                  <?php
              } else {
                  if ($isActive == 0): ?>
                    <input type="button" value="Get an offer" class="btn btn-primary" onclick="on()"></input>
                  <?php endif;
              }
            } else {
                ?>
                <p class="btn" style="margin-top: 10%">You need to <a href="loginPage.php">log in</a> to make an offer.</p>
                <?php
            }
                
        ?>
        
          <?php include 'includes/offer_settings.php'; ?>

        </div>
      </div>
    </div>

    <div class="complictations">
      <form method="get" action="offerPage.php">
            <div class="conf-card">
                <div class="conf-card-header">
                    <div class="header-content">
                        <h6>Choose a Configuration</h6>
                        <input type="hidden" name="offerID" value="<?php echo $offerID; ?>">
                        <input type="hidden" name="choose_configuration" value="Choose Configuration">                     
                        <button type="submit" name="ChooseBtn">Choose</button>
                    </div>
                </div>
                <div class="conf-options">
              
                          <?php foreach ($selectedOfferDetails as $detail): ?>
                            <?php if (!isset($_SESSION['roleID']) || $_SESSION['roleID'] == 0): ?>
                              <?php if($detail['active_status'] == 0 OR $detail['active_status'] == 'Null'): ?>
                                <div class="conf-option">
                                    <input type="radio" id="<?php echo $detail['detailsID']; ?>" name="detailsID" value="<?php echo $detail['detailsID']; ?>" <?php echo ($detail['detailsID'] == $selectedDetailsID) ? 'checked' : ''; ?>>
                                    <label for="<?php echo $detail['detailsID']; ?>">
                                        <?php echo $detail['engine_type']; ?><br>
                                        <?php echo $detail['transmission_type']; ?><br>
                                        <?php echo ucfirst($detail['color']); ?><br>
                                        <div class="offer-divider"></div>
                                        <span class="price-label"><?php echo $detail['color_price'] + $detail['transmission_price'] + $detail['price'] + $detail['engine_price']; ?>€</span>
                                    </label>
                                </div>
                              <?php endif; ?>
                            <?php else: ?>
                
                          <div class="conf-option">
                              <input type="radio" id="<?php echo $detail['detailsID']; ?>" name="detailsID" value="<?php echo $detail['detailsID']; ?>" <?php echo ($detail['detailsID'] == $selectedDetailsID) ? 'checked' : ''; ?>>
                              <label for="<?php echo $detail['detailsID']; ?>">
                                  <?php echo $detail['engine_type']; ?><br>
                                  <?php echo $detail['transmission_type']; ?><br>
                                  <?php echo ucfirst($detail['color']); ?><br>
                                  <div class="offer-divider"></div>
                                  <span class="price-label"><?php echo $detail['color_price'] + $detail['transmission_price'] + $detail['price'] + $detail['engine_price']; ?>€</span>
                              </label>
                          </div>
                    <?php endif; ?>
                  <?php endforeach; ?>
              </div>

            </div>
      </form>
    </div>

  </div>
</div>

  <div id="overlay_order" onclick="off()">
    <div id="text" class="form-container">
      <form method="post">
        
        <input type="hidden" name="detailsID" value="<?php echo isset($_GET['detailsID']) ? $_GET['detailsID'] : ''; ?>">
        <input type="hidden" name="offerID" value="<?php echo $selectedOffer['offerID'] ?>">

        <div class="form-group2">
          <label for="name"><strong>Name:</strong></label>
          <input type="text" class="form-control" id="name" name="name" maxlength="20" required>
        </div>
        <div class="form-group2">
          <label for="surname"><strong>Surname:</strong></label>
          <input type="text" class="form-control" id="surname" name="surname" maxlength="20" required>
        </div>
        <div class="form-group2">
            <label for="telephone"><strong>Telephone:</strong></label>
            <input type="text" class="form-control" id="telephone" name="telephone" maxlength="14" required>
        </div>

        <script>
          document.getElementById("telephone").addEventListener("input", function() {
              this.value = this.value.replace(/\D/g, "");
          });
        </script>

        <br>
        <div class="form-group2" style="display: flex; align-items: center;">
          <input type="checkbox" id="check" name="check" required>
          <label for="check" style="color: red;">* </label>
          <label></label>
          <p>I have read and agree to the <a href='infoPage.php'>terms and conditions</a>.</p>
        </div>
        <input type="button" value="Submit" class="btn btn-primary" onclick="showConfirmationModal()">

        <input type="button" value="Cancel" onclick="off(event)" id="cancelButton" class="btn btn-primary">
        <?php include 'includes/confirm_order.php'; ?>
      </form>
    </div>
  </div>

<?php include 'footer.php'; ?>
</body>

</html>