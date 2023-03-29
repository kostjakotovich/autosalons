<?php
session_start(); //Start the session.
require_once 'connection.php';

?>

<html>
    <head>
      <meta charset="UTF-8">
      <title>Sign Up</title>
      <!-- Подключение стилей Bootstrap -->

        <!-- Подключение скриптов -->
        <script src="../autosalons/js/script.js" defer></script>
        <script src="../autosalons/js/registration.js" defer></script>
        <link rel="stylesheet" href="css/index.css">
    </head>
    <body>

        <?php
        require 'header.php';
        ?>

    <!-- REGISTRATION FORM -->

    <form class="form-container" action="registration.php" method="POST">
            <div class="modal-body mx-3">
                <div class="md-form mb-5">
                <i></i>
                <input type="text" id="username2" name="username" class="form-control validate">
                <label data-error="wrong" data-success="right" for="orangeForm-name">Your name</label>
                </div>
                <div class="md-form mb-5">
                <i class="fas fa-envelope prefix grey-text"></i>
                <input type="email" class="form-control validate" value="" name="email" id="email">
                <label data-error="wrong" data-success="right" for="orangeForm-email" >Your email</label>
                </div>

                <div class="md-form mb-4">
                <i class="fas fa-lock prefix grey-text"></i>
                <input type="password" class="form-control validate" name="password">
                <label data-error="wrong" data-success="right" for="orangeForm-pass" >Your password</label>
                </div>

            </div>
            <div class="modal-footer d-flex justify-content-center">
                <?php

                    echo "<button class='btn btn-deep-orange' name='reg' type='submit'>Sign up</button>";
                ?>
            </div>
            </div>
        </div>
        </div>
    </form>
    <div style="text-align:center">
        <button id="cancel" onclick="closeRegistration()" class='btn btn-deep-orange' style="text-align:center">Cancel</button>
        <button onclick="RedToLogin()" class='btn btn-deep-orange' style="align:center">Sign In</button>
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