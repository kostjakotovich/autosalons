<?php
session_start();
require_once 'connection.php';

?>

<html>
    <head>
      <script src="../autosalons/js/script.js" defer></script>
      
      <link rel="stylesheet" href="css/reglog.css">
      <title>Sign In</title>
    </head>
    <body>

    <?php
      require 'header.php';
    ?>

    <div class="video-background">
        <video autoplay muted loop id="bg-video">
            <source src="img/videos/3063475-uhd_3840_2160_30fps.mp4" type="video/mp4">
            Your browser does not support HTML5 video.
        </video>
        <div class="overlay"></div>
    </div>

    <!-- REGISTRATION FORM -->
    <div class="regLogForm">
        <form action="login.php" method="POST" class="form-container">
                <div class="modal-body mx-3">
                    <h3 style="text-align: center; color: #333; margin-bottom: 10%; text-decoration: underline; font-weight: bold;">Sign In</h3>
                    
                    <input type="text" class="form-control validate" value="" name="username" id="username2" style="width: 300px;">
                    <label data-error="wrong" data-success="right" for="orangeForm-name">Your name</label>

                    <div class="md-form mb-4">
                        <i class="fas fa-lock prefix grey-text"></i>
                        <input type="password" class="form-control validate" name="password" style="width: 300px; margin-top:15%;">
                        <label data-error="wrong" data-success="right" for="orangeForm-pass" >Your password</label>
                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <?php

                        echo "<button class='btn btn-deep-orange' type='submit'>Sign In</button>";
                    ?>
                </div>
        </form>
        <br><br>

        <div style="text-align:center">
            <button onclick="RedToHomepage()" class='btn btn-deep-orange'>Cancel</button>
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
    </div>
    

 </body>