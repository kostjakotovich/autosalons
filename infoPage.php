<?php
session_start();
require_once 'connection.php';
?>

<html>
<head>
    <?php require 'header.php'; ?>
    <link rel="stylesheet" href="css/infoPage.css">
</head>
<body>
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
            </div>
        </div>
        <div class="map-container" style="width: 50%; margin: 0 auto; margin-top: 5%;">
    <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d543.9373888905965!2d24.1044798!3d56.953092!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sru!2slv!4v1707247168370!5m2!1sru!2slv" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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