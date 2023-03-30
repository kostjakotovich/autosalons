<?php
session_start();
require_once 'connection.php';
require_once 'Offer.php';

$offer = new Offer();
$offers = $offer->getAllOffers();

?>

<html>
<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="css/cards.css">
  <link rel="stylesheet" href="css/homepage.css">
</head>
<body>
<?php require 'header.php'; ?>
<form action="phpSearchOption.php" method="post" style="text-align:center">
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
  Meklēt pēc: <select name="column">
  <option value="name">Name</option>
  <option value="email">Email</option>
  </select><br>
  <input type ="submit">
</form>
  <?php foreach ($offers as $selectedOffer) { ?>
    <div class="col-md-3">
      <div class="card">
        <img src="img/<?php echo $selectedOffer['image']; ?>.webp" alt="Car Image">
        <div class="card-body">
          <h5 class="card-title"><?php echo $selectedOffer['manufacturer'] . ' ' . $selectedOffer['type']; ?></h5>
          <a href="offerPage.php?offerID=<?php echo $selectedOffer['offerID']; ?>" class="btn btn-primary">View</a>
        </div>
      </div>
    </div>
  <?php } ?>
</body>
</html>
