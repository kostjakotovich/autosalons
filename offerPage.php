<?php
session_start();

require_once 'connection.php';
require_once 'Offer.php';
require_once 'User.php';
require_once 'Order.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);


$offerID = isset($_GET['offerID']);
if (isset($_GET['offerID'])) {
  $offerID = $_GET['offerID'];
  $offer = new Offer();
  $selectedOffer = $offer->getOffer($offerID);
  $selectedOfferColor = $offer->getOfferColor($offerID);
  $selectedOfferColors = $offer->getOfferColors($offerID);
  $selectedOfferInfo = $offer->getOfferInfo($offerID);

    // Проверяем, был ли выбран цвет
  if (isset($_GET['choose_color'])) {
    $selectedColor = $_GET['color'];
    // Здесь вы можете использовать $selectedColor для отображения предложения с выбранным цветом
    $selectedOfferColor = $offer->getOfferColorByColor($offerID, $selectedColor);
  } else {
    // Если цвет не выбран, отображаем предложение по умолчанию
    $selectedColor = null; // Можете использовать это для проверки в других частях страницы
    $selectedOfferColor = $offer->getOfferColor($offerID); // По умолчанию
  }

  if (isset($_GET['color'])) {
    $selectedColor = $_GET['color'];
    // Здесь вы можете использовать $selectedColor для отображения предложения с выбранным цветом
    $_SESSION['selectedColor'] = $selectedColor; // Сохраняем выбранный цвет в сессии
    $selectedOfferColor = $offer->getOfferColorByColor($offerID, $selectedColor);
} else {
    // Если цвет не выбран, отображаем предложение по умолчанию
    $selectedColor = $_SESSION['selectedColor'] ?? null; // Попытка получить сохраненный цвет из сессии
    $selectedOfferColor = $offer->getOfferColorByColor($offerID, $selectedColor); // Используем сохраненный цвет
}

  // Get the color price for the selected color
  $colorPrice = $offer->getColorPrice($offerID, $selectedColor);
  $colorPriceDisplay = isset($colorPrice) ? "+ <span class='green-text'>" . $colorPrice . " € (Color)</span>" : "";

  // Display the color price next to the car's price
  $carPriceDisplay = $selectedOfferInfo['price'] . ' € ' . $colorPriceDisplay;
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
    // Получаем colorID из формы
    $colorID = $_POST['colorID'];
    echo "<script>event.preventDefault();</script>";
    if (isset($_SESSION['userID'])) {
        $order = new Order();
        $order->createOrder($_POST['name'], $_POST['surname'], $_POST['telephone'], $_POST['offerID'], $_POST['colorID']);
    } else {
      // Handle the case where the user is not logged in
    }
  }


?>
<html>
<head>
  <?php require 'header.php'; ?>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
  <script src="../autosalons/js/script.js" defer></script>
  <script src="../autosalons/js/form-popup.js" defer></script>
  <link rel="stylesheet" href="css/offerPage.css">


<script>
// JavaScript код для установки выбранного цвета в форме
document.addEventListener('DOMContentLoaded', function() {
  const selectedColor = "<?php echo $selectedColor ?>"; // Получаем выбранный цвет из PHP
  if (selectedColor) {
    const colorRadio = document.querySelector(`input[name="color"][value="${selectedColor}"]`);
    if (colorRadio) {
      colorRadio.checked = true; // Устанавливаем флажок для выбранного цвета
    }
  }
});

window.addEventListener('beforeunload', function() {
    <?php unset($_SESSION['selectedColor']); ?>
});

</script>

</head>
<body>
<div class="container2">
  
  <img id="colorImage" src="<?php echo $selectedOfferColor['image']; ?>" style="float: left; width: 960px; height: 520px;">

  <div class="card">
    <div class="card-body">
      <h5 class="card-title"><?php echo $selectedOffer['manufacturer'] . ' ' . $selectedOffer['type']; ?></h5>
      <br>
      <br>
      <h5>More information:</h5>
      <br>

      <form method="get" action="offerPage.php">
        <label>Choose a color:</label><br>
        <?php foreach ($selectedOfferColors as $color) { ?>
          <div class="color-option">
            <input type="radio" name="color" value="<?php echo $color['color']; ?>">
            <?php echo ucfirst($color['color']); ?>
          </div>
        <?php } ?>
        <div class="center-button">
          <input type="hidden" name="offerID" value="<?php echo $offerID; ?>">
          <input type="hidden" name="choose_color" value="Choose Color">
          <button type="submit" name="ChooseBtn" style="">Choose color</button>
        </div>
      </form>

      <p class="card-text"><?php echo 'Price: ' . $carPriceDisplay; ?></p>
      <p class="card-text"><?php echo 'Year Of Manufacture: ' . date('Y', strtotime($selectedOfferInfo['yearOfManufacture'])); ?></p>
      <p class="card-text"><?php echo 'Weight: ' . $selectedOfferInfo['weight'] . ' kg'; ?></p>
      <?php 
          if (isset($_SESSION['success'])) {
            if ($hasActiveOrders) {
                ?>
                <br>
                <p class="btn" style="margin-top: -0.5%">Wait for a response to Your previous order.</p>
                <?php
            } else {
                ?>
                <input type="button" value="Get an offer" class="btn" onclick="on()"></input>
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
            <button id="settingsButton" class="btn" onclick="toggleSettings()">Settings</button>
            <div id="settingsForm">
                      <!-- Форма для редактирование информации -->
                      <form method="post" action="edit_information.php" enctype="multipart/form-data">
                          <p for="newColor" class="card-text" style="text-align: center; margin-top: 20px; margin-bottom: 20px;"><strong>Edit Information:</strong></p>
                          <input type="text" id="type" name="type" placeholder="Model"><br><br>
                          <input type="text" id="manufacturer" name="manufacturer" placeholder="Manufacturer"><br><br>
                          <input type="text" id="color" name="color" placeholder="Color Name"><br><br>
                          <input type="text" id="color_price" name="color_price" placeholder="Color Price"><br><br>
                          <input type="text" id="price" name="price" placeholder="Car Price" pattern="[0-9\.]+"><br><br>
                          <input type="text" id="weight" name="weight" placeholder="Weight" pattern="[0-9\.]+"><br><br>
                          <input type="date" id="yearOfManufacture" name="yearOfManufacture" placeholder="Year of Manufacture"><br><br>
                          <!-- поле для загрузки изображения -->                        
                          <label class="custom-file-upload">
                            <span class="custom-file-upload-text">Choose File</span>
                            <input type="file" id="car_image" name="car_image" accept="image/*" data-file-name="No file chosen">
                          </label>

                          <input type="hidden" name="offerID" value="<?php echo $selectedOffer['offerID']; ?>">
                          <button class="btn" type="submit">Save changes</button>
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
                          <button class="btn" type="submit">Add</button>
                      </form>
                      <div class="color-options-container">
                        <!-- Ссылки для удаления цветов -->
                        <?php foreach ($selectedOfferColors as $color) { ?>
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
</div>

  <div id="overlay" onclick="off()">
    <div id="text" class="form-container">
      <form method="post" action="offerPage.php">
        
        <input type="hidden" name="colorID" value="<?php echo $selectedOfferColor['colorID']; ?>">
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
        <br>
        <input type="submit" name="submit_order" value="Submit" class="btn btn-primary">

        <input type="button" value="Cancel" onclick="off(event)" id="cancelButton" class="btn btn-primary">

      </form>
    </div>
  </div>
<div class="hidden-container"></div>

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