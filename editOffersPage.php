<?php
session_start();
require_once 'Offer.php';

if (!isset($_SESSION['userID']) || $_SESSION['roleID'] != 1) {
    header("Location: index.php");
    exit();
}

// Проверяем, является ли пользователь администратором
if ($_SESSION['roleID'] !== 1) {
    // Если нет, то перенаправляем на главную страницу
    header('Location: index.php');
    exit();
}

function checkDateFormat($date, $format)
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Offer</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="css/editOffersPage.css">

  <!-- alert close JS -->
  <script src="js/order-success-close.js" defer></script>

  <!-- For calendar-->
  <script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="//code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
  <script>
    $(function() {
    $("#yearOfManufacture").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true,
        yearRange: "1900:{{ date('Y') }}",
    });
    });
  </script>

</head>

<body>
    <?php require 'header.php'; ?>

    <?php
    if (isset($_POST['submit'])) {
        $yearOfManufacture = $_POST['yearOfManufacture'];
        $isValidDate = checkDateFormat($yearOfManufacture, 'Y-m-d');
        if (!$isValidDate) {
                echo '<div class="alert alert-danger text-center" style="margin-top:20px;">Invalid date format. Please enter the date in the format yyyy-mm-dd.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                </button>
                </div>';
        } else {
            // Convert price and weight to float
            $_POST['price'] = floatval($_POST['price']);
            $_POST['weight'] = floatval($_POST['weight']);

            $offer = new Offer();
            $offer->addOffer($_POST);
            header("Location: editOffersPage.php");
            exit();
        }
        
    }
    ?>

    <?php 
    if(isset($_SESSION['offer_add_success'])){
    ?>
      <div class="alert alert-success text-center" role="alert">
        <?php echo $_SESSION['offer_add_success']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    <?php
    
    unset($_SESSION['offer_add_success']);
    }
    ?>

    <div class="container">

        <form method="POST" action="" enctype="multipart/form-data" class="add-offer-form">
            <label for="type">Model:</label><br>
            <input type="text" id="type" name="type" required><br><br>

            <label for="manufacturer">Manufacturer:</label><br>
            <input type="text" id="manufacturer" name="manufacturer" required><br><br>

            <label for="image">Image:</label><br>
            <input type="file" id="image" name="image" accept="image/*" required><br><br>

            <label for="color">Color:</label><br>
            <input type="text" id="color" name="color" required><br><br>

            <label for="price">Price:</label><br>
            <input type="text" id="price" name="price" required pattern="[0-9\.]+"><br><br>

            <label for="yearOfManufacture">Year of Manufacture:</label><br>
            <input type="text" id="yearOfManufacture" name="yearOfManufacture" required><br><br>

            <label for="weight">Weight:</label><br>
            <input type="text" id="weight" name="weight" required pattern="[0-9\.]+"><br><br>

            <input type="submit" name="submit" value="Add Offer">
        </form>
    </div>
</body>
</html>