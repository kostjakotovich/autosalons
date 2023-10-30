<?php
session_start();
require_once 'connection.php';
require_once 'Offer.php';
require_once 'phpSearchOption.php';

$offer = new Offer();
$offers = $offer->getAllOffers();

$searchOption = new SearchOption();

if(isset($_GET['searchBtn'])) {
  $search = $_GET['search'];
  $selectedBrand = $_GET['brand'] ?? '';
  $currentPrice = $_GET['price'] ?? '';
  $offers = $searchOption->searchOffers($search, $selectedBrand, $currentPrice);
  }

$selectedBrand = $_GET['brand'] ?? '';

// массив с иконками и производителями
$carBrands = [  
  'BMW',  
  'Mercedes-Benz',  
  'Tayota',
  'Hyundai',
  'Tesla',
  'Lamborghini',
  'Volkswagen'
];

$currentPrice = $_GET['price'] ?? '';
if (!$currentPrice) {
  $currentPrice = 150000;
}


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

<img src="img/banner/car_Photo_x4_mainpage.jpg" alt="Homepage banner" style="max-width: 100%;">

<div>
    <?php 
    if(isset($_SESSION['order_success'])){
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
    <!-- Фильтр по цене и бренду -->
    <div class="form-group">
        <label for="price"><strong>Price:</strong></label>
        <input type="range" class="form-control-range" id="price" name="price" min="0" max="300000" step="1000" value="<?php echo $currentPrice ?>" oninput="limitMaxPrice(this)">
    <div id="price-output">0 - <?php echo"$currentPrice" ?> </div>

    <script>
    function limitMaxPrice(elem) {
      if (elem.value < 1500) {
        elem.value = 1500;
      }
      document.getElementById('price-output').textContent = '0 - ' + elem.value;
    }
    </script>

    </div>

    

    <!-- JavaScript для обновления значения максимальной цены -->
    <script>
      var priceInput = document.getElementById('price');
      var priceOutput = document.getElementById('price-output');

      priceInput.addEventListener('input', function() {
        priceOutput.textContent = '0 - ' + priceInput.value;
      });
      
    </script>

    <div class="form-group">
        <label for="brand"><strong>Brand:</strong></label>
        <select name="brand" class="form-control" id="brand">
            <option value="">All Brands</option>  
            <?php foreach ($carBrands as $brand) { ?>
                <option value="<?php echo $brand ?>" <?php echo $brand == $selectedBrand ? 'selected' : '' ?>>
                    <?php echo $brand ?>
                </option>
            <?php } print_r ($_GET)?>
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
                        <a href="offerPage.php?offerID=<?php echo $selectedOffer['offerID']; ?>&color=<?php echo $selectedOffer['color']; ?>" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
    <?php } ?>
  </div>
</div>


</body>
  <?php include 'footer.php'; ?>
</html>