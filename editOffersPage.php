<?php
session_start();
require_once 'connection.php';
require_once 'Offer.php';

if (!isset($_SESSION['userID']) || $_SESSION['roleID'] !== 1) {
    header("Location: index.php");
    exit();
}

$offer = new Offer();
$colors = $offer->getAllColors();
$transmissions = $offer->getAllTransmissions();
$engines = $offer->getAllEngines();

if (isset($_POST['submit'])) {
    $yearOfManufacture = $_POST['yearOfManufacture'];
    $_POST['color_price'] = floatval($_POST['color_price']);
    $_POST['transmission_price'] = floatval($_POST['transmission_price']);
    $_POST['engine_price'] = floatval($_POST['engine_price']);
    $_POST['price'] = floatval($_POST['price']);
    $_POST['weight'] = floatval($_POST['weight']);

    $offer->addOffer($_POST);
}

require_once 'includes/car_body_types.php';
?>


<html>
<head>
  <?php require 'header.php'; ?>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="css/editOffersPage.css">

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
                        <input type="text" id="type" name="type" maxlength="20" required><br><br>

                        <label for="manufacturer">Manufacturer:</label><br>
                        <input type="text" id="manufacturer" name="manufacturer" maxlength="20" required><br><br>

                        <label for="body_type">Body Type:</label><br>
                        <select name="body_type" id="body_type" class="select1" required>
                            <option value="">Select Body Type</option>
                            <?php
                            foreach ($carBodyTypes as $bodyType) {
                                echo '<option value="' . $bodyType . '">' . $bodyType . '</option>';
                            }
                            ?>
                        </select><br><br>

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
                        <input type="text" id="weight" name="weight" maxlength="20" required pattern="[0-9\.]+"><br><br>

                        <label for="price">Car Price:</label><br>
                        <input type="text" id="price" name="price" maxlength="20" required pattern="[0-9\.]+"><br><br>
                    </td>
                    <td>
                        <label for="image">Image:</label><br>
                        <input type="file" id="image" name="image" accept="image/*" required><br><br>

                        <label for="color">Color:</label><br>
                        <select name="color" id="color" class="select1" required>
                            <option value="">Select Color</option>
                            <?php
                            foreach ($colors as $color) {
                                echo '<option value="' . $color['color_name'] . '">' . $color['color_name'] . '</option>';
                            }
                            ?>
                        </select><br><br>

                        <label for="color">Color Price:</label><br>
                        <input type="text" id="color_price" name="color_price" maxlength="20" required pattern="[0-9\.]+"><br><br>

                    </td>
                    <td>
                        <label for="transmission">Transmission:</label><br>
                        <select name="transmission_type" id="transmission_type" class="select1" required>
                            <option value="">Select Transmission</option>
                            <?php
                            foreach ($transmissions as $transmission) {
                                echo '<option value="' . $transmission['transmission'] . '">' . $transmission['transmission'] . '</option>';
                            }
                            ?>
                        </select><br><br>

                        <label for="transmission">Transmission Price:</label><br>
                        <input type="text" id="transmission_price" name="transmission_price" maxlength="20" required pattern="[0-9\.]+"><br><br>

                    </td>
                    <td>
                        <label for="engine">Engine Type:</label><br>
                        <select name="engine_type" id="engine_type" class="select1" required>
                            <option value="">Select Engine</option>
                            <?php
                            foreach ($engines as $engine) {
                                echo '<option value="' . $engine['engine'] . '">' . $engine['engine'] . '</option>';
                            }
                            ?>
                        </select><br><br>

                        <label for="engine">Engine Price:</label><br>
                        <input type="text" id="engine_price" name="engine_price" maxlength="20" required pattern="[0-9\.]+"><br><br>

                    </td>
                </tr>
            </table>
            <input type="submit" name="submit" value="Add Offer" class="add-offer-button">
            <a href="configuration_attributes.php" class="btn btn-secondary">Go to Configuration</a>
        </form>
    </div>

  <?php include 'footer.php'; ?>

</body>
</html>