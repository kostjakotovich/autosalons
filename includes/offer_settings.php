<?php if(isset($_SESSION['roleID'])): ?>
            <?php if ($_SESSION['roleID'] == 1): ?>
              <button id="settingsButton" class="btn btn-primary" onclick="openModal()">Settings</button>
              <div id="settingsModal" class="modal-settings">
                <div class="modal-settings-content">
                        <span class="close" onclick="closeModal()">&times;</span>
                        <div class="settings-tabs">
                            <button id="editTab" class="setTabButton" onclick="showTab('edit')">Edit Information</button>
                            <button id="addConfigTab" class="setTabButton" onclick="showTab('addConfig')">Add Configuration</button>
                            <button id="manageOptionsTab" class="setTabButton" onclick="showTab('manageOptions')">Manage Options</button>
                        </div>

                        <div id="editForm" class="tabContent">
                            <form method="post" action="edit_information.php" enctype="multipart/form-data">
                                <p class="card-text" style="text-align: center; margin-top: 20px; margin-bottom: 20px;"><strong>Edit Information:</strong></p>
                                <div style="display: flex;">
                                    <!-- Первая колонка -->
                                    <div style="flex: 1; padding-right: 20px;">
                                        <h6>Common Parameters</h6><br>
                                        <div class="offer-settings-divider"></div>
                                        <label for="type" style="display: block;">Model:</label>
                                        <input type="text" id="type" name="type" value="<?php echo $selectedOffer['type']; ?>" style="width: 80%;" required><br><br>
                                        <label for="manufacturer" style="display: block;">Manufacturer:</label>
                                        <input type="text" id="manufacturer" name="manufacturer" value="<?php echo $selectedOffer['manufacturer']; ?>" style="width: 80%;" required><br><br>
                                        <label for="yearOfManufacture" style="display: block;">Year of Manufacture:</label>
                                        <input type="text" id="yearOfManufacture" name="yearOfManufacture" value="<?php echo $selectedOfferInfo['yearOfManufacture'] ?>" style="width: 80%;" required><br><br>
                                        <label for="weight" style="display: block;">Weight:</label>
                                        <input type="text" id="weight" name="weight" pattern="[0-9\.]+" value="<?php echo $selectedOfferInfo['weight']; ?>" style="width: 80%;" required><br><br>
                                        <label for="body_type" style="display: block;">Body type:</label>
                                        <input type="text" id="body_type" name="body_type" value="<?php echo $selectedOfferInfo['body_type']; ?>" style="width: 80%;" required><br><br>
                                        <label for="price" style="display: block;">Car Price:</label>
                                        <input type="text" id="price" name="price" pattern="[0-9\.]+" value="<?php echo $selectedOfferInfo['price']; ?>" style="width: 80%;" required><br><br>
                                    </div>

                                    <!-- Вторая колонка -->
                                    <div style="flex: 1; padding-left: 20px;">
                                        <h6>Configuration Parameters</h6><br>
                                        <div class="offer-settings-divider"></div>
                                        <label for="transmission_type" style="display: block;">Transmission:</label>
                                        <input type="text" id="transmission_type" name="transmission_type" value="<?php echo $selectedOfferTransmission['transmission_type']; ?>" style="width: 80%;" required><br><br>
                                        <label for="color" style="display: block;">Color Name:</label>
                                        <input type="text" id="color" name="color" value="<?php echo $selectedOfferColor['color']; ?>" style="width: 80%;" required><br><br>
                                        <label for="engine_type" style="display: block;">Engine Type:</label>
                                        <input type="text" id="engine_type" name="engine_type" value="<?php echo $selectedOfferEngine['engine_type']; ?>" style="width: 80%;" required><br><br>
                                        <label for="color_price" style="display: block;">Color Price:</label>
                                        <input type="text" id="color_price" name="color_price" value="<?php echo $selectedOfferColor['color_price']; ?>" style="width: 80%;" required><br><br>
                                        <label for="transmission_price" style="display: block;">Transmission Price:</label>
                                        <input type="text" id="transmission_price" name="transmission_price" value="<?php echo $selectedOfferTransmission['transmission_price']; ?>" style="width: 80%;" required><br><br>
                                        <label for="engine_price" style="display: block;">Engine Price:</label>
                                        <input type="text" id="engine_price" name="engine_price" value="<?php echo $selectedOfferEngine['engine_price']; ?>" style="width: 80%;" required><br><br>

                                        <!-- поле для загрузки изображения -->                        
                                        <label class="custom-file-upload">
                                            <span class="custom-file-upload-text">Choose File</span>
                                            <input type="file" id="car_image" name="car_image" accept="image/*" data-file-name="No file chosen">
                                        </label><br>
                                    </div>
                                </div>

                                <input type="hidden" name="detailsID" value="<?php echo $_GET['detailsID']; ?>">
                                <input type="hidden" name="offerID" value="<?php echo $selectedOffer['offerID']; ?>">
                                <button class="btn btn-primary" type="submit" style="width: 30%;">Save changes</button>
                            </form>
                        </div>

                        <div id="addConfigForm" class="tabContent">
                            <form method="post" action="actions/add_configuration.php" enctype="multipart/form-data">
                                <p class="card-text" style="text-align: center; margin-top: 20px; margin-bottom: 20px;"><strong>Add Configuration:</strong></p>
                                
                                <!-- Введите необходимые поля для добавления комплектации -->
                                <label for="color" style="display: block;">Color:</label>
                                <input type="text" id="color" name="color" style="width: 40%;" required><br><br>

                                <!-- Поле для загрузки изображения -->   
                                <label for="color">Image:</label>   
                                <br><br>                  
                                <label class="custom-file-upload">
                                    <span class="custom-file-upload-text">Choose File</span>
                                    <input type="file" id="car_image" name="car_image" accept="image/*">
                                </label>
                                <br><br>

                                <label for="color_price" style="display: block;">Color Price:</label>
                                <input type="text" id="color_price" name="color_price" style="width: 40%;" required><br><br>

                                <label for="transmission_type" style="display: block;">Transmission Type:</label>
                                <input type="text" id="transmission_type" name="transmission_type" style="width: 40%;" required><br><br>

                                <label for="transmission_price" style="display: block;">Transmission Price:</label>
                                <input type="text" id="transmission_price" name="transmission_price" style="width: 40%;" required><br><br>

                                <label for="engine_type" style="display: block;">Engine Type:</label>
                                <input type="text" id="engine_type" name="engine_type" style="width: 40%;" required><br><br>

                                <label for="engine_price" style="display: block;">Engine Price:</label>
                                <input type="text" id="engine_price" name="engine_price" style="width: 40%;" required><br><br>

                                <input type="hidden" name="detailsID" value="<?php echo $_GET['detailsID']; ?>">
                                <input type="hidden" name="offersInfoID" value="<?php echo $offersInfoID; ?>">
                                <input type="hidden" name="offerID" value="<?php echo $selectedOffer['offerID']; ?>">

                                <button class="btn btn-primary" type="submit" style="width: 40%;">Add Configuration</button>
                            </form>
                        </div>

                        <div id="manageOptionsForm" class="tabContent">
                            <?php if(isset($_SESSION['roleID']) && $_SESSION['roleID'] == 1): ?>
                                <form method="post">
                                    <?php if ($isActive == 1): ?>
                                        <button type="submit" name="activate_offer" class="status-btn">Activate</button>
                                    <?php else: ?>
                                        <button type="submit" name="deactivate_offer" class="status-btn">Deactivate</button>
                                    <?php endif; ?>
                                </form>
                            <?php endif; ?>

                            <form method="post">
                                <input type="hidden" name="detailsID" value="<?php echo isset($_GET['detailsID']) ? $_GET['detailsID'] : ''; ?>">
                                <input type="hidden" name="offerID" value="<?php echo $selectedOffer['offerID']; ?>">
                                <?php if(isset($_SESSION['roleID'])): ?>
                                    <?php if ($_SESSION['roleID'] == 1): ?>
                                    <button type="button" name="delete_configuration" class="delete-conf-btn">Delete</button>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </form>
                        </div>

                    <br>
                </div>
                <br>
              </div>               
    <?php endif; ?>
<?php endif; ?>

<script>
    // Получаем ссылку на модальное окно
    var modal = document.getElementById('settingsModal');

    function openModal() {
        modal.style.display = 'block';
        document.getElementById('editTab').classList.add('activeSetTab');
        document.getElementById('addConfigTab').classList.remove('activeSetTab');
        document.getElementById('manageOptionsForm').classList.remove('activeSetTab');
        document.getElementById('editForm').style.display = 'block';
        document.getElementById('addConfigForm').style.display = 'none';
        document.getElementById('manageOptionsForm').style.display = 'none';
    }

    // Функция для скрытия модального окна
    function closeModal() {
        modal.style.display = 'none';
    }

    function showTab(tabName) {
        if (tabName === 'edit') {
            document.getElementById('editForm').style.display = 'block';
            document.getElementById('addConfigForm').style.display = 'none';
            document.getElementById('manageOptionsForm').style.display = 'none';
            
            // Добавляем стиль активной кнопке "Edit"
            document.getElementById('editTab').classList.add('activeSetTab');
            // Убираем стиль активной кнопки с "Add Configuration"
            document.getElementById('addConfigTab').classList.remove('activeSetTab');
            document.getElementById('manageOptionsTab').classList.remove('activeSetTab');
        } else if (tabName === 'addConfig') {
            document.getElementById('editForm').style.display = 'none';
            document.getElementById('addConfigForm').style.display = 'block';
            document.getElementById('manageOptionsForm').style.display = 'none';
            
            // Добавляем стиль активной кнопке "Add Configuration"
            document.getElementById('addConfigTab').classList.add('activeSetTab');
            // Убираем стиль активной кнопки с "Edit"
            document.getElementById('editTab').classList.remove('activeSetTab');
            document.getElementById('manageOptionsTab').classList.remove('activeSetTab');
        } else if (tabName === 'manageOptions') {
            document.getElementById('editForm').style.display = 'none';
            document.getElementById('addConfigForm').style.display = 'none';
            document.getElementById('manageOptionsForm').style.display = 'block';
            
            // Добавляем стиль активной кнопке "Manage Options"
            document.getElementById('manageOptionsTab').classList.add('activeSetTab');
            // Убираем стили активных кнопок с "Edit" и "Add Configuration"
            document.getElementById('editTab').classList.remove('activeSetTab');
            document.getElementById('addConfigTab').classList.remove('activeSetTab');
        }
    }
</script>

<style>
    .setTabButton {
        background-color: #f2f2f2;
        border: none;
        color: #333;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 5px;
        margin-right: 10px; 
        outline: none; 
    }

    .activeSetTab {
        background-color: #007bff;
        color: #fff;
    }

    .settings-tabs{
        margin-top: 2%;
    }

    .offer-settings-divider {
        border-bottom: 1px solid #ccc;
        width: 70%;
        margin: 0 auto; /* Центрирование по горизонтали */
        margin-top: -5%;
        margin-bottom: 5%;
    }

</style>
