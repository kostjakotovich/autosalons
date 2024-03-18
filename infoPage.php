<?php
session_start();
require_once 'connection.php';
?>

<html>
<head>
    <link rel="stylesheet" href="css/infoPage.css">
</head>
<body>
    <?php require 'header.php'; ?>
    <div class="box">
    <div class="info-container">
        <div class="info-header" onclick="toggleInfo('section1')">About Us</div>
            <div class="info-content" id="section1">
                <p>Welcome to our car dealership! We offer a wide selection of vehicles, from sports sedans to powerful SUVs. Our team of experienced experts is always ready to help you choose a vehicle that suits your needs.</p>
            </div>
            <br>
            <div class="info-header" onclick="toggleInfo('section2')">Services</div>
            <div class="info-content" id="section2">
                <p>We offer a full range of automotive services, including the sale of new and used cars, providing information about available colors and configurations, as well as warranty and post-warranty maintenance.</p>
            </div>
            <br>
            <div class="info-header" onclick="toggleInfo('section3')">Vehicles</div>
            <div class="info-content" id="section3">
                <p>Here you will find a wide selection of vehicles from various makes and models. We provide detailed descriptions of each vehicle, including specifications, photos, and color options. You can choose a vehicle that matches your preferences and budget.</p>
            </div>
            <br>
            <div class="info-header" onclick="toggleInfo('section4')">Colors</div>
            <div class="info-content" id="section4">
            <p>We offer a variety of color options for every vehicle. We have cars in various colors to meet your stylistic preferences. You can choose your perfect color to make your car unique.</p>
            </div>
            <br>
            <div class="info-header" onclick="toggleInfo('section5')">Contact Us</div>
            <div class="info-content" id="section5">
                <p>If you have any questions or need additional information about our vehicles and services, please feel free to contact us. We are ready to answer your inquiries and help you make the right choice.</p>
                <br>
                <p><strong>Phone:</strong> +371 123456789</p>
                <p><strong>E-mail:</strong> info@yoursalon.com</p>
                <h6>More information <a href='contacts.php'>here</a>.</h6>
            </div>
        </div>

    </div>
    <script>
        function toggleInfo(sectionId) {
            const content = document.getElementById(sectionId);
            if (content.style.display === 'block') {
                content.style.display = 'none';
            } else {
                content.style.display = 'block';
            }
        }
    </script>
    <?php include 'footer.php'; ?>
</body>
</html>