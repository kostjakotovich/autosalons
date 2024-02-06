<?php
session_start();
require_once 'connection.php';
require_once 'Offer.php';
require_once 'phpSearchOption.php';

$offer = new Offer();
$offers = $offer->getAllOffers();

$searchOption = new SearchOption();

if (isset($_GET['searchBtn'])) {
    $search = $_GET['search'];
    $selectedBrand = $_GET['brand'] ?? '';
    $selectedTransmission = $_GET['selectedTransmission'] ?? '';
    $selectedColor = $_GET['color'] ?? '';
    $currentMinPrice = $_GET['minPrice'] ?? 0;
    $currentMaxPrice = $_GET['maxPrice'] ?? '';

    $offers = $searchOption->searchOffers($search, $selectedBrand, $selectedColor, $currentMinPrice, $currentMaxPrice);
}

$selectedTransmission = $_GET['selectedTransmission'] ?? '';
$selectedBrand = $_GET['brand'] ?? '';
$selectedColor = $_GET['color'] ?? '';

require_once 'includes/car_colors.php';
require_once 'includes/car_brands.php';

$currentMinPrice = $_GET['minPrice'] ?? '';
$currentMaxPrice = $_GET['maxPrice'] ?? '';

?>

<html>
<head>
    <?php require 'header.php'; ?>
    <!-- alert close JS -->
    <script src="js/order-success-close.js" defer></script>

    <link rel="stylesheet" href="css/cards.css">
    <link rel="stylesheet" href="css/homepage.css">
</head>
<body>
<script src="../autosalons/js/script.js" defer></script>

<div style="position: relative; max-width: 100%; margin-top: 0%;">
    <img src="img/banner/car_Photo_x4_mainpage.jpg" alt="Homepage banner" style="max-width: 100%;">
    <a href='#container2' style="position: absolute; top: 20px; right: 20px; color: white; font-size: 24px; text-decoration: none; background: rgba(0, 0, 0, 0.5); padding: 10px;  background-color: #000;
  color: #fff;
  font-size: 24px;
  padding: 10px 20px;
  border-radius: 5px;">Try it now</a>
</div>

<div>
    <?php
    if (isset($_SESSION['order_success'])) {
        ?>
        <div class="alert alert-success text-center" role="alert">
            <?php echo $_SESSION['order_success']; ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <?php
        unset($_SESSION['order_success']);
    }
    ?>
</div>

<div class="main-wrapper">
    <form action="" method="get" style="text-align:center; margin-top: 3%;">
        <div style="display: flex; justify-content: center; text-align: center;">

            <input type="text" placeholder="Search.." name="search" style="width: 40%;
        margin-left: 2%;
        text-align: center;
        box-sizing: border-box;
        border: 2px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        background-color: white;
        background-position: 10px 10px;
        background-repeat: no-repeat;
        padding: 12px 20px 12px 40px;
        -webkit-transition: width 0.4s ease-in-out;
        transition: width 0.4s ease-in-out;">

            <button type="submit" name="searchBtn" style="margin-left: 10px;">Search</button>

        </div>

        <div class="filters">
          <!-- Контейнер для цены -->
          <div class="price-container">
              <label for="minPrice"></label>
              <input type="text" id="minPrice" name="minPrice" placeholder="0 €" value="<?php echo $currentMinPrice ?>" style="width: 70px;">

              <label for="maxPrice"></label>
              <input type="text" id="maxPrice" name="maxPrice" placeholder="- €" value="<?php echo $currentMaxPrice ?>" style="width: 70px; margin-left:50%;">
          </div>

          <div class="form-group">
              <label for="brand"><strong>Brand:</strong></label>
              <select name="brand" class="form-control" id="brand">
                  <option value="">All Brands</option>
                  <?php foreach ($carBrands as $brand) { ?>
                      <option value="<?php echo $brand ?>" <?php echo $brand == $selectedBrand ? 'selected' : '' ?>>
                          <?php echo $brand ?>
                      </option>
                  <?php } print_r($_GET) ?>
              </select>
          </div>

          

          <div class="form-group">
            <label for="color"><strong>Color:</strong></label>
            <select name="color" class="form-control" id="color">
                <option value="">All Colors</option>
                <?php foreach ($carColors as $color) { ?>
                    <option value="<?php echo $color ?>" <?php echo $color == $selectedColor ? 'selected' : '' ?>>
                        <?php echo $color ?>
                    </option>
                <?php } print_r($_GET) ?>
            </select>
          </div>

      </div>

    </form>

    <div id="container2">
        <div class="card-wrapper">
            <?php foreach ($offers as $selectedOffer) { ?>
                <div class="card-wrapper">
                    <div class="card">
                        <img src="<?php echo $selectedOffer['image']; ?>" alt="Car Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $selectedOffer['manufacturer'] . ' ' . $selectedOffer['type']; ?></h5>
                            <a href="offerPage.php?offerID=<?php echo $selectedOffer['offerID']; ?>&color=<?php echo $selectedOffer['color']; ?>"
                               class="btn btn-primary">View</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

</body>
<?php include 'footer.php'; ?>
</html>
