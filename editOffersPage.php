<?php
session_start();
require_once 'connection.php';
require_once 'Offer.php';

if (!isset($_SESSION['userID']) || $_SESSION['roleID'] !== 1) {
    header("Location: index.php");
    exit();
}

    if (isset($_POST['submit'])) {
        $yearOfManufacture = $_POST['yearOfManufacture'];
        $_POST['color_price'] = floatval($_POST['color_price']);
        $_POST['price'] = floatval($_POST['price']);
        $_POST['weight'] = floatval($_POST['weight']);

        $offer = new Offer();
        $offer->addOffer($_POST);
        
    }
?>

<html>
<head>
  <?php require 'header.php'; ?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="css/editOffersPage.css">

  <!-- alert close JS -->
  <script src="js/order-success-close.js" defer></script>

  <!-- For calendar-->
  <script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="//code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>

</head>

<body>

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

    <div class="container-offer">

        <form method="POST" action="" enctype="multipart/form-data" class="add-offer-form" style="width: 50%;">
            <table>
                <tr>
                  <th class="car">1. Car</th>
                  <th class="color">2. Color</th>
                  <th class="transmission">3. Transmission</th>
                  <th class="engine">4. Engine</th>
                </tr>
                <tr>
                    <td>
                        <label for="type">Model:</label><br>
                        <input type="text" id="type" name="type" required><br><br>

                        <label for="manufacturer">Manufacturer:</label><br>
                        <input type="text" id="manufacturer" name="manufacturer" required><br><br>

                        <label for="body_type">Body Type:</label><br>
                        <input type="text" id="body_type" name="body_type" required><br><br>

                        <label for="yearOfManufacture">Year of Manufacture:</label><br>
                        <select name="yearOfManufacture" id="yearOfManufacture" class="select1" required>
                            <option value="">Select Year</option>
                            <?php
                            $currentYear = date('Y');
                            for ($year = 1990; $year <= $currentYear; $year++) {
                                echo '<option value="' . $year . '">' . $year . '</option>';
                            }
                            ?>
                        </select>

                        <label for="weight">Weight:</label><br>
                        <input type="text" id="weight" name="weight" required pattern="[0-9\.]+"><br><br>

                        <label for="price">Car Price:</label><br>
                        <input type="text" id="price" name="price" required pattern="[0-9\.]+"><br><br>
                    </td>
                    <td>
                        <label for="image">Image:</label><br>
                        <input type="file" id="image" name="image" accept="image/*" required><br><br>

                        <label for="color">Color:</label><br>
                        <input type="text" id="color" name="color" required><br><br>

                        <label for="color">Color Price:</label><br>
                        <input type="text" id="color_price" name="color_price" required><br><br>

                    </td>
                    <td>
                        <label for="transmission">Transmission:</label><br>
                        <input type="text" id="transmission_type" name="transmission_type" required><br><br>

                        <label for="transmission">Transmission Price:</label><br>
                        <input type="text" id="transmission_price" name="transmission_price" required><br><br>

                    </td>
                    <td>
                        <label for="engine">Engine Type:</label><br>
                        <input type="text" id="engine_type" name="engine_type" required><br><br>

                        <label for="engine">Engine Price:</label><br>
                        <input type="text" id="engine_price" name="engine_price" required><br><br>

                    </td>
                </tr>
            </table>
            <input type="submit" name="submit" value="Add Offer" class="add-offer-button">
        </form>
    </div>

  <?php include 'footer.php'; ?>
</body>
</html>