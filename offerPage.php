<?php
session_start();

require_once 'connection.php';
require_once 'Offer.php';
require_once 'User.php';
require_once 'Order.php';

error_reporting(E_ALL);
ini_set('display_errors', 1); 

$userID = $_SESSION['userID'];
$user = new UserMain($userID);
$userInfo = $user->getUserInfo();

$offerID = isset($_GET['offerID']);
if (isset($_GET['offerID'])) {
  $offerID = $_GET['offerID'];
  $offer = new Offer();
  $offersInfoID = $offer->getOffersInfoID($offerID);

  $selectedOffer = $offer->getOffer($offerID);
  $selectedOfferColor = $offer->getOfferColor($offersInfoID);
  $selectedOfferDetails = $offer->getOfferDetails($offersInfoID);
  $selectedOfferTransmission = $offer->getOfferTransmission($offersInfoID);
  $selectedOfferInfo = $offer->getOfferInfo($offerID);

  if (isset($_GET['choose_configuration'])) {
    $selectedDetailsID = $_GET['detailsID'];
    $selectedOfferDetails = $offer->getOfferDetailsByID($selectedDetailsID);
  } else {
    // Если комплектация не выбрана, отображаем предложение по умолчанию
    $selectedDetailsID = null;
    $selectedOfferDetails = $offer->getOfferDetails($offersInfoID); // По умолчанию
  }


  if (isset($_GET['detailsID'])) {
    $selectedDetailsID = $_GET['detailsID'];
    $_SESSION['selectedDetailsID'] = $selectedDetailsID; 
    $selectedOfferDetails = $offer->getOfferDetailsByID($selectedDetailsID);
} else {
    // Если комплектация не выбрана, отображаем предложение по умолчанию
    $selectedDetailsID = $_SESSION['selectedDetailsID'] ?? null;
    $selectedOfferDetails = $offer->getOfferDetailsByID($selectedDetailsID);
}

  $carPriceDisplay = $selectedOfferInfo['price'] + $selectedOfferTransmission['transmission_price'] + $selectedOfferColor['color_price'] . ' € ';
} 



if (isset($_SESSION['success'])) {
  $order = new Order($offerID, $_SESSION['userID']);

  $hasActiveOrders = $order->checkOrdersStatus();
}

if (isset($_POST['submit_order'])) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $telephone = $_POST['telephone'];
    // Получаем colorID из формы
    $detailsID = $_POST['detailsID'];
    echo "<script>event.preventDefault();</script>";
    if (isset($_SESSION['userID'])) {
        $order = new Order();
        $order->createOrder($_POST['name'], $_POST['surname'], $_POST['telephone'], $_POST['offerID'], $_POST['detailsID']);
    } else {
      // Handle the case where the user is not logged in
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
        <h5 class="card-title"><?php echo $selectedOffer['manufacturer'] . ' ' . $selectedOffer['type']; ?></h5>
        <div class="offer-divider"></div>
        <p class="card-text"><?php echo 'Year Of Manufacture: ' . $selectedOfferInfo['yearOfManufacture']; ?></p>
        <p class="card-text"><?php echo 'Body Type: ' . $selectedOfferInfo['body_type']; ?></p>
        <p class="card-text"><?php echo 'Transmission: ' . $selectedOfferTransmission['transmission_type']; ?></p>
        <p class="card-text"><?php echo 'Weight: ' . $selectedOfferInfo['weight'] . ' kg'; ?></p>
        <p class="card-text"><?php echo 'Color: ' . $selectedOfferColor['color']; ?></p>
        <p class="card-text"><?php echo 'Car Price: ' . $selectedOfferInfo['price'] . ' €'; ?></p>
        <p class="card-text"><?php echo 'Color Price: ' . $selectedOfferColor['color_price'] . ' €'; ?></p>
        <p class="card-text"><?php echo 'Transmission Price: ' . $selectedOfferTransmission['transmission_price'] . ' €'; ?></p>
        <p class="card-text"><?php echo 'Final Price: ' . $carPriceDisplay; ?></p>

        <?php 
            if (isset($_SESSION['success'])) {
              if ($hasActiveOrders) {
                  ?>
                  <br>
                  <p class="btn" style="margin-top: -0.5%">Wait for a response to Your previous order.</p>
                  <?php
              } else {
                  ?>
                  <input type="button" value="Get an offer" class="btn btn-primary" onclick="on()"></input>
                  <?php
              }
            } else {
                ?>
                <p class="btn" style="margin-top: -0.5%">You need to log in to make an offer.</p>
                <?php
            }
                
        ?>

          <?php if(isset($_SESSION['roleID'])): ?>
            <?php if ($_SESSION['roleID'] == 1): ?>
              <button id="settingsButton" class="btn btn-primary" onclick="toggleSettings()">Settings</button>
              <div id="settingsForm">
                        <!-- Форма для редактирование информации -->
                        <form method="post" action="edit_information.php" enctype="multipart/form-data">
                            <p for="newColor" class="card-text" style="text-align: center; margin-top: 20px; margin-bottom: 20px;"><strong>Edit Information:</strong></p>
                            <label for="type">Model:</label>
                            <input type="text" id="type" name="type" value="<?php echo $selectedOffer['type'] ?>"><br><br>

                            <label for="manufacturer">Manufacturer:</label>
                            <input type="text" id="manufacturer" name="manufacturer" value="<?php echo $selectedOffer['manufacturer'] ?>"><br><br>

                            <label for="color">Color Name:</label>
                            <input type="text" id="color" name="color" value="<?php echo $selectedOfferColor['color'] ?>"><br><br>

                            <label for="color_price">Color Price:</label>
                            <input type="text" id="color_price" name="color_price" value="<?php echo $selectedOfferColor['color_price'] ?>"><br><br>

                            <label for="price">Car Price:</label>
                            <input type="text" id="price" name="price" pattern="[0-9\.]+" value="<?php echo $selectedOfferInfo['price'] ?>"><br><br>

                            <label for="weight">Weight:</label>
                            <input type="text" id="weight" name="weight" pattern="[0-9\.]+" value="<?php echo $selectedOfferInfo['weight'] ?>"><br><br>

                            <label for="yearOfManufacture">Year of Manufacture:</label>
                            <input type="text" id="yearOfManufacture" name="yearOfManufacture" value="<?php echo $selectedOfferInfo['yearOfManufacture'] ?>"><br><br>

                            <!-- поле для загрузки изображения -->                        
                            <label class="custom-file-upload">
                              <span class="custom-file-upload-text">Choose File</span>
                              <input type="file" id="car_image" name="car_image" accept="image/*" data-file-name="No file chosen">
                            </label>

                            <input type="hidden" name="offerID" value="<?php echo $selectedOffer['offerID']; ?>">
                            <button class="btn btn-primary" type="submit">Save changes</button>
                        </form>

                        <!-- Форма для добавления новых цветов -->
                        <form method="post" action="process_color.php" enctype="multipart/form-data">
                            <p for="newColor" class="card-text" style="text-align: center; margin-top: 20px; margin-bottom: 20px;"><strong>Add New Color:</strong></p>      
                            <input type="text" id="newColor" name="newColor" placeholder="Color Name" required>
                            <br><br>
                            <!-- <label for="colorPrice" class="card-text"></label> -->
                            <input type="number" id="colorPrice" name="colorPrice" placeholder="Color Price" required>
                            <br><br>
                            <!-- поле для загрузки изображения -->                        
                            <label class="custom-file-upload">
                              <span class="custom-file-upload-text">Choose File</span>
                              <input type="file" id="colorImage" name="colorImage" accept="image/*" required data-file-name="No file chosen">
                            </label>

                            <input type="hidden" name="offerID" value="<?php echo $selectedOffer['offerID']; ?>">
                            <button class="btn btn-primary" type="submit">Add</button>
                        </form>
                        <div class="color-options-container">
                          <!-- Ссылки для удаления цветов -->
                          <?php foreach ($selectedOfferDetails as $color) { ?>
                            <br>
                            <div class="color-item">
                              <div class="color-info">
                                <?php echo ucfirst($color['color']); ?>
                              </div>
                              <a href="delete_color.php?offerID=<?php echo $selectedOffer['offerID']; ?>&color=<?php echo $color['color']; ?>" class="btn btn-danger" role="button" style="width: ;">Delete color</a>
                            </div>
                          <?php } ?>
                        </div>
                    <br>
                    <div><button class="btn btn-danger">Delete offer</button></div>
              <br>
            </div>               
            <?php endif; ?>
          <?php endif; ?>
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
                    <?php foreach ($selectedOfferDetails as $detail) { ?>
                        <div class="conf-option">
                            <input type="radio" id="<?php echo $detail['detailsID']; ?>" name="detailsID" value="<?php echo $detail['detailsID']; ?>">
                            <label for="<?php echo $detail['detailsID']; ?>">
                                <?php echo $detail['transmission_type']; ?>
                                <br>
                                <?php echo ucfirst($detail['color']); ?>
                                <br>
                                <div class="offer-divider"></div>
                                <span class="price-label">€<?php echo $detail['color_price'] + $detail['transmission_price'] + $detail['price']; ?></span>
                            </label>
                        </div>
                    <?php } ?>
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
          <input type="text" class="form-control" id="telephone" name="telephone" maxlength="14" required value="+371 ">
        </div>
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
<script>
  // JavaScript код для убирания атрибута readonly
document.addEventListener('input', function (e) {
    if (e.target.id === 'telephone') {
        e.target.removeAttribute('readonly');
    }
});

function toggleSettings() {
  const settingsForm = document.getElementById('settingsForm');
  if (settingsForm.style.display === 'none' || settingsForm.style.display === '') {
    settingsForm.style.display = 'block';
  } else {
    settingsForm.style.display = 'none';
  }
}


</script>


<?php include 'footer.php'; ?>
</body>

</html>