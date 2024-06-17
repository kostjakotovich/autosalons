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
    $selectedModel = $_GET['model'] ?? '';
    $selectedTransmission = $_GET['transmission'] ?? '';
    $selectedType = $_GET['type'] ?? '';
    $selectedYear = $_GET['year'] ?? '';
    $selectedColor = $_GET['color'] ?? '';
    $currentMinPrice = $_GET['minPrice'] ?? 0;
    $currentMaxPrice = $_GET['maxPrice'] ?? '';

    $offers = $searchOption->searchOffers($search, $selectedBrand, $selectedModel, $selectedType, $selectedYear, $selectedColor, $selectedTransmission, $currentMinPrice, $currentMaxPrice);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['brand']) && !isset($_GET['searchBtn'])) {
    $brand = $_GET['brand'];
    $models = $offer->getModelsByBrand($brand);

    if ($models === false) {
        echo json_encode(['error' => 'Failed to fetch models']);
    } else {
        echo json_encode($models);
    }
    exit;
}

$search = $_GET['search'] ?? '';
$selectedType = $_GET['type'] ?? '';
$selectedBrand = $_GET['brand'] ?? '';
$selectedColor = $_GET['color'] ?? '';
$selectedTransmission = $_GET['transmission'] ?? '';
$selectedYear = $_GET['year'] ?? '';
$currentMinPrice = $_GET['minPrice'] ?? '';
$currentMaxPrice = $_GET['maxPrice'] ?? '';

require_once 'includes/car_body_types.php';

$allTransmissions = $offer->getAllTransmissions();
$allColors = $offer->getAllColors();

$carBrands = $offer->getAllBrands();

?>

<html>
<head>
    <script src="js/order-success-close.js" defer></script>

    <link rel="stylesheet" href="css/cards.css">
    <link rel="stylesheet" href="css/homepage.css">
    <script src="../autosalons/js/script.js" defer></script>
    <script src="js/slider.js" defer></script>
</head>
<body>
<?php require 'header.php'; ?>
<div class="banner-container">
    <div class="slider">
        <img src="img/banner/car_Photo_x4_mainpage.jpg" alt="Homepage banner" class="slide active">
        <img src="img/banner/gabriel-unsplash.jpg" alt="Homepage banner" class="slide">
        <img src="img/banner/toine-g-iRnUeA04kUY-unsplash.jpg" alt="Homepage banner" class="slide">
        <img src="img/banner/andrew-pons-Os7C4iw2rDc-unsplash.jpg" alt="Homepage banner" class="slide">
        <img src="img/banner/liubomyr-vovchak--8tcHun6Qps-unsplash.jpg" alt="Homepage banner" class="slide">
    </div>
    <button class="prev-button">&#10094;</button>
    <button class="next-button">&#10095;</button>
    <a href='#container2' class="banner-link">Try it now</a>
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
    <form action="" method="get" class="search-form">
        <input type="text" class="search_input" placeholder="Search..." name="search" value="<?php echo htmlspecialchars($search, ENT_QUOTES); ?>" maxlength="50">
        <button type="submit" name="searchBtn" class="search-btn">Search</button>
    
    
        <div class="content-wrapper">
            <div class="filters">
                <div class="price-container">
                    <label for="minPrice"></label>
                    <input type="text" maxlength="8" id="minPrice" name="minPrice" placeholder="0 €" value="<?php echo $currentMinPrice ?>" style="width: 70px;">
                    <label for="maxPrice"></label>
                    <input type="text" maxlength="8" id="maxPrice" name="maxPrice" placeholder="- €" value="<?php echo $currentMaxPrice ?>" style="width: 70px; margin-left:50%;">
                </div>

                <script>
                    document.getElementById('minPrice').addEventListener('input', function(e) {
                        this.value = this.value.replace(/[^0-9]/g, '');
                    });

                    document.getElementById('maxPrice').addEventListener('input', function(e) {
                        this.value = this.value.replace(/[^0-9]/g, '');
                    });
                </script>


                <div class="form-group">
                    <label for="brand"><strong>Brand:</strong></label>
                    <select name="brand" class="form-control" id="brand">
                        <option value="">All Brands</option>
                        <?php foreach ($carBrands as $brand) { ?>
                            <option value="<?php echo $brand ?>"><?php echo $brand ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group" id="model-group">
                    <label for="model"><strong>Model:</strong></label>
                    <select name="model" class="form-control" id="model" disabled>
                        <option value="">Select Brand First</option>
                    </select>
                </div>

                <script>
                    document.getElementById('brand').addEventListener('change', function() {
                        var selectedBrand = this.value;
                        var modelSelect = document.getElementById('model');
                        
                        modelSelect.innerHTML = '<option value="">Select Brand First</option>';

                        if (selectedBrand) {
                            fetch('index.php?brand=' + encodeURIComponent(selectedBrand)) 
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Network response was not ok');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    modelSelect.disabled = false;
                                    modelSelect.innerHTML = '<option value="">All models</option>';

                                    data.forEach(function(model) {
                                        var option = document.createElement('option');
                                        option.value = model;
                                        option.textContent = model;
                                        modelSelect.appendChild(option);
                                    });
                                })
                                .catch(error => {
                                    console.error('Error fetching models:', error);
                                });
                        } else {
                            modelSelect.disabled = true;
                        }
                    });

                    var urlParams = new URLSearchParams(window.location.search);
                    var selectedBrand = urlParams.get('brand');
                    var selectedModel = urlParams.get('model');
                    var modelSelect = document.getElementById('model');

                    if (selectedBrand) {
                        document.getElementById('brand').value = selectedBrand;
                        fetch('index.php?brand=' + encodeURIComponent(selectedBrand))
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                modelSelect.disabled = false;
                                modelSelect.innerHTML = '<option value="">All models</option>';

                                data.forEach(function(model) {
                                    var option = document.createElement('option');
                                    option.value = model;
                                    option.textContent = model;
                                    modelSelect.appendChild(option);
                                });

                                if (selectedModel && data.includes(selectedModel)) {
                                    modelSelect.value = selectedModel;
                                }
                            })
                            .catch(error => {
                                console.error('Error fetching models:', error);
                            });
                    }
                </script>



                <div class="form-group">
                    <label for="year"><strong>Manufacturing Year:</strong></label>
                    <select name="year" class="form-control" id="year">
                        <option value="">All Years</option>
                        <?php 
                        $startYear = 1990;
                        $endYear = date("Y");
                        
                        for($year = $endYear; $year >= $startYear; $year--) { ?>
                            <option value="<?php echo $year ?>" <?php echo $year == $selectedYear ? 'selected' : '' ?>>
                                <?php echo $year ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="color"><strong>Color:</strong></label>
                    <select name="color" class="form-control" id="color">
                        <option value="">All Colors</option>
                        <?php foreach ($allColors as $color) { ?>
                            <option value="<?php echo $color['color_name'] ?>" <?php echo $color['color_name'] == $selectedColor ? 'selected' : '' ?>>
                                <?php echo $color['color_name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="type"><strong>Body type:</strong></label>
                    <select name="type" class="form-control" id="type">
                        <option value="">All types</option>
                        <?php foreach ($carBodyTypes as $type) { ?>
                            <option value="<?php echo $type ?>" <?php echo $type == $selectedType ? 'selected' : '' ?>>
                                <?php echo $type ?>
                            </option>
                        <?php } print_r($_GET) ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="transmission"><strong>Transmissions:</strong></label>
                    <select name="transmission" class="form-control" id="transmission">
                        <option value="">All Transmissions</option>
                        <?php foreach ($allTransmissions as $transmission) { ?>
                            <option value="<?php echo $transmission['transmission'] ?>" <?php echo $transmission['transmission'] == $selectedTransmission ? 'selected' : '' ?>>
                                <?php echo $transmission['transmission'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div id="container2" class="offers-container">
                <?php if (count($offers) === 0) { ?>
                    <div class="no-results">
                        <p>Sorry, but we couldn't find anything.</p>
                    </div>
                <?php } else { ?>
                    <div class="card-wrapper">
                        <?php foreach ($offers as $selectedOffer) { ?>
                            <?php if (!isset($_SESSION['roleID']) || $_SESSION['roleID'] == 0): ?>
                                <?php if($selectedOffer['active_status'] == 0 OR $selectedOffer['active_status'] == 'Null'): ?>
                                    <div class="card" onclick="location.href='offerPage.php?offerID=<?php echo $selectedOffer['offerID']; ?>&detailsID=<?php echo $selectedOffer['detailsID']; ?>';">
                                        <img src="<?php echo $selectedOffer['image']; ?>" alt="Car Image" class="car_image">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $selectedOffer['manufacturer'] . ' ' . $selectedOffer['type']; ?></h5>
                                            <p class="card-text">Year: <?php echo $selectedOffer['yearOfManufacture']; ?></p>
                                            <p class="card-text">Price: $<?php echo ($selectedOffer['price']+$selectedOffer['color_price']+$selectedOffer['transmission_price']+$selectedOffer['engine_price']); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="card" onclick="location.href='offerPage.php?offerID=<?php echo $selectedOffer['offerID']; ?>&detailsID=<?php echo $selectedOffer['detailsID']; ?>';">
                                    <div class="offer-status">
                                        <?php if($selectedOffer['active_status'] == 0 OR $selectedOffer['active_status'] == 'Null'): ?>
                                            <p class="text-active">🟢Active</p>
                                        <?php endif; ?>
                                        <?php if($selectedOffer['active_status'] == 1): ?>
                                            <p class="card-not-active">🔴Not active</p>
                                        <?php endif; ?>
                                    </div>

                                    <img src="<?php echo $selectedOffer['image']; ?>" alt="Car Image" class="car_image">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $selectedOffer['manufacturer'] . ' ' . $selectedOffer['type']; ?></h5>
                                        <p class="card-text">Year: <?php echo $selectedOffer['yearOfManufacture']; ?></p>
                                        <p class="card-text">Price: $<?php echo ($selectedOffer['price']+$selectedOffer['color_price']+$selectedOffer['transmission_price']+$selectedOffer['engine_price']); ?></p>
                                    </div>
                                </div>

                            <?php endif; ?>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </form>
</div>


</body>
<?php include 'footer.php'; ?>
</html>
