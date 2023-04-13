<?php
session_start();
require_once 'connection.php';
require_once 'Offer.php';


$offer = new Offer();
$offers = $offer->getAllOffers();

if(isset($_GET['search'])) {
  $search = $_GET['search'];
  $column = $_GET['column'] ?? 'manufacturer'; // Поиск по марке по умолчанию
  $offers = $offer->searchOffers($search, $column);
} else {
  $offers = $offer->getAllOffers();
}

?>

<html>
<head>

  <!-- Bootstrap JS -->
  <script src="bootstrap-5.1.3-dist\js\bootstrap.min.js"></script>

   <!-- alert close JS -->
   <script src="js/order-success-close.js" defer></script>
   
   
  <link rel="stylesheet" href="css/cards.css">
  <link rel="stylesheet" href="css/homepage.css">
</head>
<body>
<?php require 'header.php'; ?>

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

<form action="" method="post" style="text-align:center">
  <input type="text" placeholder="Search.." name="search" style="width: 60%;
  margin: auto;
  text-align: center;
  box-sizing: border-box;
  border: 2px solid #ccc;
  border-radius: 4px;
  font-size: 16px;
  background-color: white;
  background-image: url('searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  padding: 12px 20px 12px 40px;
  -webkit-transition: width 0.4s ease-in-out;
  transition: width 0.4s ease-in-out;">
  <input type="submit">
</form>

<div class="card-wrapper">
  <?php foreach ($offers as $selectedOffer) { ?>
          <div class="card-wrapper">
              <div class="card">
                  <img src="img/<?php echo $selectedOffer['image']; ?>.webp" alt="Car Image">
                  <div class="card-body">
                      <h5 class="card-title"><?php echo $selectedOffer['manufacturer'] . ' ' . $selectedOffer['type']; ?></h5>
                      <a href="offerPage.php?offerID=<?php echo $selectedOffer['offerID']; ?>" class="btn btn-primary">View</a>
                  </div>
              </div>
          </div>
  <?php } ?>
</div>

</body>
</html>
