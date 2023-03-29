<?php
session_start(); //Start the session.
require_once 'connection.php';

?>

<html>
    <head>
      <script src="../autosalons/js/script.js" defer></script>
      <script src="../autosalons/js/registration.js" defer></script>
      
      <link rel="stylesheet" href="css/homepage.css">
      <title>Sign In</title>
    </head>
    <body>

    <?php
      require 'header.php';
    ?>
    <!-- REGISTRATION FORM -->

    <form action="login.php" method="POST">
            <div class="modal-body mx-3">
                
                
                <input type="text" class="form-control validate" value="" name="name" id="username2">
                <label data-error="wrong" data-success="right" for="orangeForm-name">Your name</label>
                


                <div class="md-form mb-4">
                <i class="fas fa-lock prefix grey-text"></i>
                <input type="password" class="form-control validate" name="password">
                <label data-error="wrong" data-success="right" for="orangeForm-pass" >Your password</label>
                </div>

            </div>
            <div class="modal-footer d-flex justify-content-center">
                <?php

                    echo "<button class='btn btn-deep-orange' type='submit'>Sign In</button>";
                ?>
            </div>
            </div>
        </div>
        </div>
    </form>
    <div style="text-align:center">
        <button id="cancel" onclick="closeLogin()" class='btn btn-deep-orange'>Cancel</button>
        <button onclick="RedToRegistration()" class='btn btn-deep-orange'>Sign Up</button>
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