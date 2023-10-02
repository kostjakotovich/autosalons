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
  $selectedOfferColor = $offer->getOfferColor($offerID);
  $selectedOfferColors = $offer->getOfferColors($offerID);
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


<img id="colorImage" src="<?php echo $selectedOfferColor['image']; ?>" style="float:left">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title"><?php echo $selectedOffer['manufacturer'] . ' ' . $selectedOffer['type']; ?></h5>
      <br>
      <br>
      <h5>More information:</h5>
      <br>

      <label>Choose a color:</label><br>
<?php foreach ($selectedOfferColors as $index => $color) { ?>
    <div class="color-option">
        <input type="radio" name="color" value="<?php echo $color['color']; ?>" data-image="<?php echo $color['image']; ?>">

        <?php echo ucfirst($color['color']); ?>
    </div>
<?php } ?>





      <br></br>
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

<?php if(isset($_SESSION['roleID'])): ?>
  <?php if ($_SESSION['roleID'] == 1): ?>
    <!-- Форма для добавления новых цветов -->
    <form method="post" action="process_color.php" enctype="multipart/form-data">
        <label for="newColor">Add New Color:</label>
        <input type="text" id="newColor" name="newColor" required>
        
        <!-- Добавьте поле для загрузки изображения -->
        <label for="colorImage">Color Image:</label>
        <input type="file" id="colorImage" name="colorImage" accept="image/*" required>
        
        <input type="hidden" name="offerID" value="<?php echo $selectedOffer['offerID']; ?>">
        <button type="submit">Add</button>
    </form>

    <!-- Ссылки для удаления цветов -->
    <?php foreach ($selectedOfferColors as $color) { ?>
    <div class="color-option">
        <input type="radio" name="color" value="<?php echo $color['color']; ?>">
        <?php echo ucfirst($color['color']); ?>
        <!-- Отображаем кнопку "-" для удаления цвета -->
        <a href="delete_color.php?offerID=<?php echo $selectedOffer['offerID']; ?>&color=<?php echo $color['color']; ?>">Delete color</a>
    </div>
<?php } ?>


  <?php endif; ?>
<?php endif; ?>


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
  
    <script>
    // Получаем ссылку на изображение и радио-кнопки цвета
const colorImage = document.getElementById("colorImage");
const colorRadios = document.querySelectorAll('input[type="radio"][name="color"]');

// Добавляем обработчик события change для радио-кнопок цвета
colorRadios.forEach(radio => {
    radio.addEventListener("change", () => {
        // Получаем индекс выбранной радио-кнопки
        const selectedIndex = radio.value;

        // Получаем URL изображения из атрибута data-image выбранной радио-кнопки
        const selectedColorImage = colorRadios[selectedIndex].getAttribute("data-image");

        // Устанавливаем новый источник изображения
        colorImage.src = selectedColorImage;
    });
});

</script>

<?php include 'footer.php'; ?>
</body>

</html>