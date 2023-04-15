<?php
session_start();
require_once 'Offer.php';


if (!isset($_SESSION['userID']) || $_SESSION['roleID'] != 1) {
    header("Location: index.php");
    exit();
}

require_once 'Offer.php';

if (isset($_POST['submit'])) {
    $offer = new Offer();
    $offer->addOffer($_POST);
    header("Location: editOffersPage.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Offer</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="css/editOffersPage.css">

  <!-- For calendar-->
  <script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="//code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
  <script>
    $(function() {
      $("#yearOfManufacture").datepicker({
        dateFormat: "yy-mm-dd"
      });
    });
  </script>
</head>

<body>
    <?php require 'header.php'; ?>
    <h1>Add Offer</h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <label for="type">Type:</label><br>
        <input type="text" id="type" name="type" required><br><br>

        <label for="manufacturer">Manufacturer:</label><br>
        <input type="text" id="manufacturer" name="manufacturer" required><br><br>

        <label for="image">Image:</label><br>
        <input type="file" id="image" name="image" accept="image/*" required><br><br>

        <label for="color">Color:</label><br>
        <input type="text" id="color" name="color" required><br><br>

        <label for="price">Price:</label><br>
        <input type="number" id="price" name="price" required><br><br>

        <label for="yearOfManufacture">Year of Manufacture:</label><br>
        <input type="text" id="yearOfManufacture" name="yearOfManufacture" required><br><br>

        <label for="weight">Weight:</label><br>
        <input type="number" id="weight" name="weight" required><br><br>

        <input type="submit" name="submit" value="Add Offer">
    </form>
</body>
</html>
