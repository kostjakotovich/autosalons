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
    // Очищаем параметр цвета из сессии
    <?php unset($_SESSION['selectedColor']); ?>
});

</script>

</head>
<body>
<div class="container2">

<img id="colorImage" src="<?php echo $selectedOfferColor['image']; ?>" style="float:left">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title"><?php echo $selectedOffer['manufacturer'] . ' ' . $selectedOffer['type']; ?></h5>
      <br>
      <br>
      <h5>More information:</h5>
      <br>

      <!-- Добавьте форму для выбора цвета -->
<form method="get" action="offerPage.php">
  <label>Choose a color:</label><br>
  <?php foreach ($selectedOfferColors as $color) { ?>
    <div class="color-option">
      <input type="radio" name="color" value="<?php echo $color['color']; ?>">
      <?php echo ucfirst($color['color']); ?>
    </div>
  <?php } ?>
  <input type="hidden" name="offerID" value="<?php echo $offerID; ?>">
  <input type="hidden" name="choose_color" value="Choose Color">
  <br>
  <button type="submit" name="ChooseBtn">Choose color</button>
</form>

      <p class="card-text"><?php echo 'Price: ' . $selectedOfferInfo['price'] . ' €'; ?></p>
      <p class="card-text"><?php echo 'Year Of Manufacture: ' . date('Y', strtotime($selectedOfferInfo['yearOfManufacture'])); ?></p>
      <p class="card-text"><?php echo 'Weight: ' . $selectedOfferInfo['weight'] . ' kg'; ?></p>
      <?php 
          if (isset($_SESSION['success'])) {
            if ($hasActiveOrders) {
                ?>
                <p class="btn" style="margin-top: -0.5%">Wait for a response to Your previous order.</p>
                <?php
            } else {
                ?>
                <input type="button" value="Get an offer" class="btn2" onclick="on()"></input>
                <?php
            }
          } else {
              ?>
              <p class="btn" style="margin-top: -0.5%">You need to log in to make an offer.</p>
              <?php
          }
              
      ?>
    </div>
  </div>
</div>

<?php if(isset($_SESSION['roleID'])): ?>
  <?php if ($_SESSION['roleID'] == 1): ?>
    <div class="card2" style="margin-left:58.5%; margin-top:-8%">
        <div class="card-body">
        <br>

              <!-- Форма для добавления новых цветов -->
              <form method="post" action="process_color.php" enctype="multipart/form-data">
                  <label for="newColor">Add New Color:</label>
                
                  <input type="text" id="newColor" name="newColor" required>
                  <br>
                  <!-- Добавьте поле для загрузки изображения -->
                  <label for="colorImage">Color Image:</label>
                
                  <input type="file" id="colorImage" name="colorImage" accept="image/*" required>
                
                  <input type="hidden" name="offerID" value="<?php echo $selectedOffer['offerID']; ?>">
                  <br>
                  <button type="submit">Add</button>
              </form>

              <!-- Ссылки для удаления цветов -->
              <?php foreach ($selectedOfferColors as $color) { ?>
              <br>
              <div class="color-option">          
                  <?php echo ucfirst($color['color']); ?>
                  <!-- Отображаем кнопку "-" для удаления цвета -->
                  <a href="delete_color.php?offerID=<?php echo $selectedOffer['offerID']; ?>&color=<?php echo $color['color']; ?>">Delete color</a>
              </div>
          <?php } ?>
          <br>
        </div>
    </div>
    <br>

  <?php endif; ?>
<?php endif; ?>


  <div id="overlay" onclick="off()">
    <div id="text" class="form-container">
      <form method="post" action="offerPage.php">

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
          <label for="check" style="color: red;">*</label> 
          <label> I have read and agree to the terms and conditions.</label> 
        </div>
        <br>
        <input type="submit" name="submit_order" value="Submit" class="btn btn-primary">

        <input type="button" value="Cancel" onclick="off(event)" id="cancelButton" class="btn btn-primary">

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

</script>


<?php include 'footer.php'; ?>
</body>

</html>