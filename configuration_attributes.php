<?php
session_start();
require_once 'connection.php';
require_once 'Offer.php';
require_once 'User.php';

$offer = new Offer();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    header('Content-Type: application/json');

    if (isset($_POST['color']) && !empty(trim($_POST['color']))) {
        $color = trim($_POST['color']);
        if ($offer->colorExists($color)) {
            echo json_encode("Color already exists");
        } else {
            $offer->addColor($color);
        }
        header("Location: configuration_attributes.php");
        exit;
    }

    if (isset($_POST['transmission']) && !empty(trim($_POST['transmission']))) {
        $transmission = trim($_POST['transmission']);
        if ($offer->transmissionExists($transmission)) {
            echo json_encode("Transmission already exists");
        } else {
            $offer->addTransmission($transmission);
        }
        header("Location: configuration_attributes.php");
        exit;
    }

    if (isset($_POST['engine']) && !empty(trim($_POST['engine']))) {
        $engine = trim($_POST['engine']);
        if ($offer->engineExists($engine)) {
            echo json_encode("Engine already exists");
        } else {
            $offer->addEngine($engine);
        }
        header("Location: configuration_attributes.php");
        exit;
    }

    if (isset($_POST['save_color'])) {
        if (isset($_POST['new_color']) && !empty(trim($_POST['new_color']))) {
            $newColor = trim($_POST['new_color']);
            $colorId = trim($_POST['color_name_id']);
            if ($offer->colorExists($newColor)) {
            } else {
                $offer->updateColor($colorId, $newColor);
            }
            header("Location: configuration_attributes.php");
            exit;
        }
    }

    if (isset($_POST['save_transmission'])) {
        if (isset($_POST['new_transmission']) && !empty(trim($_POST['new_transmission']))) {
            $newTransmission = trim($_POST['new_transmission']);
            $transmissionId = trim($_POST['transmission_name_id']);
            if ($offer->transmissionExists($newTransmission)) {
            } else {
                $offer->updateTransmission($transmissionId, $newTransmission);
            }
            header("Location: configuration_attributes.php");
            exit;
        }
    }

    if (isset($_POST['save_engine'])) {
        if (isset($_POST['new_engine']) && !empty(trim($_POST['new_engine']))) {
            $newEngine = trim($_POST['new_engine']);
            $engineId = trim($_POST['engine_name_id']);
            if ($offer->engineExists($newEngine)) {
            } else {
                $offer->updateEngine($engineId, $newEngine);
            }
            header("Location: configuration_attributes.php");
            exit;
        }
    }

    if (isset($_POST['delete_color'])) {
        $color_name_id = $_POST['color_name_id'];
        $offer->deleteColor($color_name_id);
    }

    if (isset($_POST['delete_transmission'])) {
        $transmission_name_id = $_POST['transmission_name_id'];
        $offer->deleteTransmission($transmission_name_id);
    }

    if (isset($_POST['delete_engine'])) {
        $engine_name_id = $_POST['engine_name_id'];
        $offer->deleteEngine($engine_name_id);
    }

    header("Location: configuration_attributes.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require 'header.php'; ?>
    <link rel="stylesheet" href="css/configuration_attributes.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <div class="attribute-container">
        <a href="editOffersPage.php" style="font-size: 50px; color: black;">
            <i class="bi bi-arrow-left">←</i>
        </a>

        <h1 class="text-center mb-4">Configuration Parameters</h1>
        <br>
        <div class="row">
            <div class="col-md-4 attribute-column">
                <h4>Colors</h4>
                <form id="color-form" method="post" action="">
                    <div class="attribute-form-group">
                        <input type="text" class="form-control color-input" id="color" name="color" required>
                        <button type="submit" class="btn btn-primary" id="add-color-btn">+</button>
                    </div>
                </form>

                <div class="output-container">
                    <?php
                    $colors = $offer->getAllColors();
                    foreach ($colors as $color) {
                        echo "<div class='output-item d-flex align-items-center'>
                                <form id='edit-color-form' method='post' action='' class='d-flex' style='width: 100%;'>
                                    <input type='hidden' name='color_name_id' value='{$color['color_name_id']}'>
                                    <input type='text' class='form-control mr-2' name='new_color' value='{$color['color_name']}' readonly>
                                    <button type='submit' class='btn btn-success save-btn mr-2' name='save_color' style='display: none;'>Save</button>
                                    <button type='button' class='btn btn-warning edit-btn mr-2'>Edit</button>
                                    <button name='delete_color' class='btn btn-danger mr-2'>-</button>
                                </form>
                            </div>";
                    }
                    ?>
                </div>
            </div>

            <!-- Transmissions -->
            <div class="col-md-4 attribute-column">
                <h4>Transmissions</h4>
                <form id="transmission-form" method="post" action="">
                    <div class="attribute-form-group">
                        <input type="text" class="form-control transmission-input" id="transmission" name="transmission" required>
                        <button type="submit" class="btn btn-primary" id="add-transmission-btn">+</button>
                    </div>
                </form>

                <div class="output-container">
                    <?php
                    $transmissions = $offer->getAllTransmissions();
                    foreach ($transmissions as $transmission) {
                        echo "<div class='output-item d-flex align-items-center'>
                                    <form id='edit-transmission-form' method='post' action='' class='d-flex' style='width: 100%;'>
                                        <input type='hidden' name='transmission_name_id' value='{$transmission['transmission_name_id']}'>
                                        <input type='text' class='form-control mr-2' name='new_transmission' value='{$transmission['transmission']}' readonly>
                                        <button type='submit' class='btn btn-success save-btn mr-2' name='save_transmission' style='display: none;'>Save</button>
                                        <button type='button' class='btn btn-warning edit-btn mr-2'>Edit</button>
                                        <button name='delete_transmission' class='btn btn-danger mr-2'>-</button>
                                    </form>
                                </div>";
                    }
                    ?>
                </div>
            </div>

            <!-- Engines -->
            <div class="col-md-4 attribute-column">
                <h4>Engines</h4>
                <form id="engine-form" method="post" action="">
                    <div class="attribute-form-group">
                        <input type="text" class="form-control engine-input" id="engine" name="engine" required>
                        <button type="submit" class="btn btn-primary" id="add-engine-btn">+</button>
                    </div>
                </form>

                <div class="output-container">
                    <?php
                    $engines = $offer->getAllEngines();
                    foreach ($engines as $engine) {
                        echo "<div class='output-item d-flex align-items-center'>
                                    <form id='edit-engine-form' method='post' action='' class='d-flex' style='width: 100%;'>
                                        <input type='hidden' name='engine_name_id' value='{$engine['engine_name_id']}'>
                                        <input type='text' class='form-control mr-2' name='new_engine' value='{$engine['engine']}' readonly>
                                        <button type='submit' class='btn btn-success save-btn mr-2' name='save_engine' style='display: none;'>Save</button>
                                        <button type='button' class='btn btn-warning edit-btn mr-2'>Edit</button>
                                        <button name='delete_engine' class='btn btn-danger mr-2'>-</button>
                                    </form>
                                </div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

<?php include 'footer.php'; ?>

<script>
    $(document).ready(function() {
        $('#color-form').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '',
                method: 'POST',
                data: { color: $('#color').val() },
                success: function(response) {
                    if (response === 'Color already exists') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: 'Color already exists!',
                        });
                    } else {
                        location.reload();
                    }
                }
            });
        });

        $('#transmission-form').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '',
                method: 'POST',
                data: { transmission: $('#transmission').val() },
                success: function(response) {
                    if (response === 'Transmission already exists') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: 'Transmission already exists!',
                        });
                    } else {
                        location.reload();
                    }
                }
            });
        });

        $('#engine-form').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: '',
                method: 'POST',
                data: { engine: $('#engine').val() },
                success: function(response) {
                    if (response === 'Engine already exists') {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: 'Engine already exists!',
                        });
                    } else {
                        location.reload();
                    }
                }
            });
        });

        // Edit button functionality
        $('.edit-btn').on('click', function(event) {
            event.preventDefault();
            const input = $(this).parent().find('.form-control');
            const oldValue = input.val();
            if (input) {
                input.prop('readonly', function(_, value) {
                    return !value;
                });
                const saveButton = $(this).parent().find('.save-btn');
                if (input.prop('readonly')) {
                    $(this).text('Edit');
                    $(this).removeClass('btn-success').addClass('btn-warning');
                    if (saveButton.length > 0) {
                        saveButton.hide();
                    }
                } else {
                    $(this).text('Close');
                    $(this).removeClass('btn-success').addClass('btn-warning');
                    if (saveButton.length > 0) {
                        saveButton.show();
                    }
                }
                $(this).on('click', function() {
                    input.val(oldValue); 
                });
            }
        });
    });
</script>


</body>
</html>
