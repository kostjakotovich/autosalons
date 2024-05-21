<div id="confirmation_modal" class="confirmation-modal">
  <div class="confirmation-modal-dialog confirmation-modal-lg">
    <div class="confirmation-modal-content">
      <div class="confirmation-modal-header">
        <h5 class="confirmation-modal-title">Order Confirmation</h5>
        <button type="button" class="confirmation-close" onclick="closeConfirmationModal()" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="confirmation-modal-body">
        <div class="row">
          <!-- Первый столбец с информацией об автомобиле -->
          <div class="col-md-6">
            <h6><strong>Offer Information:</strong></h6>
            <div class="divider"></div>
            <img src="<?php echo $selectedOfferColor['image']; ?>" alt="Car Photo" class="confirmation-car-photo">
            <p><strong>Manufacturer and model:</strong> <?php echo $selectedOffer['manufacturer'] . ' ' . $selectedOffer['type']; ?></p>
            <p><strong>Year Of Manufacture:</strong> <?php echo $selectedOfferInfo['yearOfManufacture']; ?></p>
            <p><strong>Body Type:</strong> <?php echo $selectedOfferInfo['body_type']; ?></p>
            <p><strong>Transmission: </strong> <?php echo $selectedOfferTransmission['transmission_type']; ?></p>
            <p><strong>Engine Type: </strong> <?php echo $selectedOfferEngine['engine_type']; ?></p>
            <p><strong>Weight:</strong> <?php echo $selectedOfferInfo['weight'] . ' kg'; ?></p>
            <p><strong>Color: </strong> <?php echo $selectedOfferColor['color']; ?></p>
            <p><strong>Color Price: </strong> <?php echo $selectedOfferColor['color_price'] . ' €'; ?></p>
            <p><strong>Transmission Price: </strong> <?php echo $selectedOfferTransmission['transmission_price'] . ' €'; ?></p>
            <p><strong>Car Price:</strong> <?php echo $selectedOfferInfo['price'] . ' €';?></p>
            <p><strong>Engine Price:</strong> <?php echo $selectedOfferEngine['engine_price'] . ' €';?></p>
            <p><strong>Total Price:</strong> <span class="final-price"><?php echo $selectedOfferInfo['price'] + $selectedOfferColor['color_price'] + $selectedOfferTransmission['transmission_price'] + $selectedOfferEngine['engine_price'] . ' €'; ?></span></p>
          </div>
          <!-- Вертикальная полоса -->
          <div class="col-md-1">
            <div class="vertical-line"></div>
          </div>
          <!-- Второй столбец с информацией о пользователе -->
          <div class="col-md-5">
            <div class="confirmation-user-info">
              <h6><strong>Customer Information:</strong></h6>
              <div class="divider"></div>
              <p><strong>Name:</strong> <span id="confirmation_name"></span></p>
              <p><strong>Surname:</strong> <span id="confirmation_surname"></span></p>
              <p><strong>Telephone:</strong> <span id="confirmation_telephone"></span></p>
              <p><strong>Email:</strong> <?php echo $userInfo['email']; ?></p>
            </div>
          </div>
        </div>
      </div>
      <div class="confirmation-modal-footer">
        <button type="button" class="confirmation-btn confirmation-btn-secondary" onclick="closeConfirmationModal()">Back</button>
        <button type="submit" name="submit_order" class="confirmation-btn confirmation-btn-primary">Confirm</button>
      </div>
    </div>
  </div>
</div>


<script>
function showConfirmationModal() {
    // Получение значений полей формы
    var name = document.getElementById("name").value;
    var surname = document.getElementById("surname").value;
    var telephone = document.getElementById("telephone").value;
    var termsChecked = document.getElementById("check").checked;

    // Проверка на заполненность всех полей и согласия с условиями
    if (name && surname && telephone && termsChecked) {
        // Если все поля заполнены и условия приняты, открываем модальное окно с подтверждением
        document.getElementById("confirmation_modal").style.display = "block";
        // Добавляем только что введённые данные в модальное окно
        document.getElementById("confirmation_name").innerText = name;
        document.getElementById("confirmation_surname").innerText = surname;
        document.getElementById("confirmation_telephone").innerText = telephone;
    } else {
        var errorText = "Please fill in all fields and accept the terms and conditions!";
        swal("Error", errorText, "error");
    }
}

function closeConfirmationModal() {
  document.getElementById("confirmation_modal").style.display = "none";
}
</script>

<style>
.confirmation-modal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 3;
}

.confirmation-modal-dialog {
  position: absolute;
  width: 200%;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: #fff;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
}

.confirmation-modal-content {
  padding: 20px;
}

.confirmation-modal-header,
.confirmation-modal-footer {
  padding: 10px;
  background-color: #f7f7f7;
  border-bottom: 1px solid #ddd;
  display: flex;
  justify-content: center; /* Центрирование по горизонтали */
}

.confirmation-modal-body {
  padding: 10px;
}

.confirmation-modal-title {
  margin: 0;
}

.confirmation-close {
  border: none;
  background: none;
  cursor: pointer;
  padding: 5px;
  position: absolute;
  top: 5px;
  right: 10px;
  font-size: 20px;
  color: #aaa;
}

.confirmation-btn {
  padding: 8px 20px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
  outline: none;
  font-size: 16px;
  margin-right: 10px;
}

.confirmation-btn-primary {
  background-color: #007bff;
  color: #fff;
}

.confirmation-btn-secondary {
  background-color: #6c757d;
  color: #fff;
}

.confirmation-user-info p {
  margin-bottom: 10px;
}

.vertical-line {
  border-left: 1px solid #ccc;
  height: 100%;
}

.confirmation-car-photo {
  max-width: 100%;
  height: auto;
  border-radius: 5px;
  margin-bottom: 10px;
  object-fit: cover;
}

.confirmation-user-info p {
  margin-bottom: 10px;
}

.final-price {
  text-decoration: underline;
  text-underline-offset: 4px; /* Дополнительный отступ между цифрами и подчеркиванием */
}

.divider {
  width: 100%; 
  height: 2px; 
  background-color: #ccc; 
  margin: 20px 0; 
}
</style>
