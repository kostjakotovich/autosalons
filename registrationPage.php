<?php
session_start(); //Start the session.
require_once 'connection.php';

?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/reglog.css">

    <!-- Подключение скриптов -->
    <script src="../autosalons/js/script.js" defer></script>
    <script src="../autosalons/js/registration.js" defer></script>

</head>
<body>

<?php
require 'header.php';
?>

<!-- REGISTRATION FORM -->

<!-- REGISTRATION FORM -->

<form action="registration.php" method="POST" class="form-container">
    <div class="modal-body mx-3">
        <div class="form-group-reg">
            <div class="md-form mb-5">
                <i></i>
                <input type="text" id="username2" name="username" class="form-control validate" style="width: 300px;">
                <label data-error="wrong" data-success="right" for="orangeForm-name">Your name</label>
            </div>
        </div>
        <div class="form-group-reg">
            <div class="md-form mb-5">
                <i class="fas fa-envelope prefix grey-text"></i>
                <input type="email" class="form-control validate" name="email" id="email" style="width: 300px;">
                <label data-error="wrong" data-success="right" for="orangeForm-email" >Your email</label>
            </div>
        </div>

        <div class="form-group-reg">
            <div class="md-form mb-4">
                <i class="fas fa-lock prefix grey-text"></i>
                <input type="password" class="form-control validate" name="password" style="width: 300px;">
                <label data-error="wrong" data-success="right" for="orangeForm-pass" >Your password</label>
            </div>
        </div>
        <br>
        <div class="form-group-reg">
            <div class="md-form mb-4">
                <i class="fas fa-lock prefix grey-text"></i>
                <input type="password" class="form-control validate" name="password_confirm" style="width: 300px;">
                <label data-error="wrong" data-success="right" for="orangeForm-pass" >Confirm password</label>
            </div>
        </div>


    </div>
    <div class="modal-footer d-flex justify-content-center">
        <?php
        echo "<button class='btn btn-deep-orange' name='reg' type='submit'>Sign Up</button>";
        ?>
    </div>

</form>
<br><br>
<div style="text-align:center">
    <button id="cancel" onclick="closeRegistration()" class='btn btn-deep-orange' style="text-align:center">Cancel</button>
    <button onclick="RedToLogin()" class='btn btn-deep-orange' style="align:center">Already have an account?</button>
</div>

<?php
if(isset($_SESSION['error'])){
    ?>
    <div class="alert alert-danger text-center" style="margin-top:20px;">
        <?php echo $_SESSION['error']; ?>
    </div>
    <?php

    unset($_SESSION['error']);
}

if(isset($_SESSION['success'])){
    ?>
    <div class="alert alert-success text-center" style="margin-top:20px;">
        <?php echo $_SESSION['success']; ?>
    </div>
    <?php

    unset($_SESSION['success']);
}
?>

</body>