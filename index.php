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

$selectedType = $_GET['type'] ?? '';
$selectedBrand = $_GET['brand'] ?? '';
$selectedColor = $_GET['color'] ?? '';
$selectedTransmission = $_GET['transmission'] ?? '';

require_once 'includes/car_body_types.php';
require_once 'includes/car_colors.php';
require_once 'includes/car_brands.php';
require_once 'includes/car_models.php';
require_once 'includes/transmissions_types.php';

$selectedYear = $_GET['year'] ?? '';
$currentMinPrice = $_GET['minPrice'] ?? '';
$currentMaxPrice = $_GET['maxPrice'] ?? '';

?>

<html>
<head>
    <script src="js/order-success-close.js" defer></script>

    <link rel="stylesheet" href="css/cards.css">
    <link rel="stylesheet" href="css/homepage.css">
    <script src="../autosalons/js/script.js" defer></script>
</head>
<body>
<?php require 'header.php'; ?>
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

            <input type="text" class="search_input" placeholder="Search.." name="search">

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

            <div class="form-group" id="model-group">
                <label for="model"><strong>Model:</strong></label>
                <select name="model" class="form-control" id="model" disabled>
                    <option value="">Select Brand First</option>
                    <!-- Опции для моделей будут добавлены динамически с помощью JavaScript -->
                </select>
            </div>

<script>
    // Ассоциативный массив с моделями для каждой марки автомобиля
    var modelsByBrand = <?php echo json_encode($modelsByBrand); ?>;

    document.getElementById('brand').addEventListener('change', function() {
    var selectedBrand = this.value;
    var modelSelect = document.getElementById('model');
    var modelGroup = document.getElementById('model-group');

    if (selectedBrand) {
        // Очистить список моделей перед добавлением новых
        modelSelect.innerHTML = '<option value="">Select Brand First</option>';
        
        // Отобразить список моделей для выбранной марки
        if (modelsByBrand[selectedBrand]) {
            modelsByBrand[selectedBrand].forEach(function(model) {
                var option = document.createElement('option');
                option.value = model;
                option.textContent = model;
                modelSelect.appendChild(option);
            });
        }
        // Активировать поле для выбора модели
        modelSelect.disabled = false;
        
        // Установить надпись в зависимости от состояния выбранной марки
        modelSelect.querySelector('option').textContent = 'All models';

        // Сбросить выбранную модель на "Select Brand First"
        modelSelect.value = '';
    } else {
        // Сделать поле недоступным для выбора, если марка не выбрана, и установить соответствующий текст
        modelSelect.disabled = true;
        modelSelect.innerHTML = '<option value="">Select Brand First</option>';
    }
});



    // Проверить, есть ли в URL-адресе параметр модели при загрузке страницы
    document.addEventListener('DOMContentLoaded', function() {
        var urlParams = new URLSearchParams(window.location.search);
        var selectedBrand = urlParams.get('brand');
        var selectedModel = urlParams.get('model');
        var modelSelect = document.getElementById('model');

        // Очистить предыдущие опции моделей и установить начальный текст
        modelSelect.innerHTML = '<option value="">Select Brand First</option>';

        if (selectedBrand) {
            // Отобразить список моделей для выбранной марки
            if (modelsByBrand[selectedBrand]) {
                modelsByBrand[selectedBrand].forEach(function(model) {
                    var option = document.createElement('option');
                    option.value = model;
                    option.textContent = model;
                    modelSelect.appendChild(option);
                });
            }
            // Активировать поле для выбора модели и установить соответствующий текст
            modelSelect.disabled = false;
            modelSelect.querySelector('option').textContent = 'All models';

            // Если модель была сохранена в URL-адресе и есть такая модель для выбранной марки, установить ее выбранным значением
            if (selectedModel && modelsByBrand[selectedBrand] && modelsByBrand[selectedBrand].includes(selectedModel)) {
                modelSelect.value = selectedModel;
            } else {
                // Если модель не была сохранена в URL-адресе, установить "Select Brand First"
                modelSelect.value = '';
            }
        } else {
            // Сделать поле недоступным для выбора, если марка не выбрана, и установить соответствующий текст
            modelSelect.disabled = true;
            modelSelect.querySelector('option').textContent = 'Select Brand First';
        }
    });

</script>

            <div class="form-group">
                <label for="year"><strong>Manufacturing Year:</strong></label>
                <select name="year" class="form-control" id="year">
                    <option value="">All Years</option>
                    <?php 
                    // Год начала
                    $startYear = 1990;
                    // текущий год
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
                    <?php foreach ($carColors as $color) { ?>
                        <option value="<?php echo $color ?>" <?php echo $color == $selectedColor ? 'selected' : '' ?>>
                            <?php echo $color ?>
                        </option>
                    <?php } print_r($_GET) ?>
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
                    <option value="">All transmissions</option>
                    <?php foreach ($transmissions as $transmission) { ?>
                        <option value="<?php echo $transmission ?>" <?php echo $transmission == $selectedTransmission ? 'selected' : '' ?>>
                            <?php echo $transmission ?>
                        </option>
                    <?php } print_r($_GET) ?>
                </select>
            </div>

        </div>

    </form>

    <div class="divider"></div>

    
    <div id="container2">
        <?php if (count($offers) === 0) { ?>
            <div class="no-results">
                <p>Sorry, but we couldn't find anything.</p>
            </div>
        <?php } else { ?>
            <div class="card-wrapper">
                <?php foreach ($offers as $selectedOffer) { ?>
                    <?php if (!isset($_SESSION['roleID']) || $_SESSION['roleID'] == 0): ?>
                        <?php if($selectedOffer['active_status'] == 0 OR $selectedOffer['active_status'] == 'Null'): ?>
                            <div class="card">
                                <img src="<?php echo $selectedOffer['image']; ?>" alt="Car Image" class="car_image">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $selectedOffer['manufacturer'] . ' ' . $selectedOffer['type']; ?></h5>
                                    <p class="card-text">Year: <?php echo $selectedOffer['yearOfManufacture']; ?></p>
                                    <p class="card-text">Price: $<?php echo ($selectedOffer['price']+$selectedOffer['color_price']+$selectedOffer['transmission_price']+$selectedOffer['engine_price']); ?></p>
                                    <a href="offerPage.php?offerID=<?php echo $selectedOffer['offerID']; ?>&detailsID=<?php echo $selectedOffer['detailsID']; ?>" class="btn btn-primary">View</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="card">
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
                                <a href="offerPage.php?offerID=<?php echo $selectedOffer['offerID']; ?>&detailsID=<?php echo $selectedOffer['detailsID']; ?>" class="btn btn-primary">View</a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>

</body>
<?php include 'footer.php'; ?>
</html>
