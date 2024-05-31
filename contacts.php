<?php
session_start();
require_once 'connection.php';
?>

<html>
<head>
    <?php require 'header.php'; ?>
    <link rel="stylesheet" href="css/contacts.css">
</head>
<body>
    <div class="emp-profile-container">
        <h2 class="emp-profile-title">> Contact Information</h2>
        <div class="emp-profile-divider"></div>
        <div class="emp-profile-contact-info">
            <p><span class="emp-profile-phone">Phone 1:</span> +371 123-45-67</p>
            <p><span class="emp-profile-phone">Phone 2:</span> +371 123-45-67</p>
            <p><span class="emp-profile-phone">Email:</span> info@yoursalon.com</p>
            <p><span class="emp-profile-address">Address 1:</span> 123456, city, Riga, st. Alexandra Chaka</p>
            <p><span class="emp-profile-address">Address 2:</span> 123456, city, Riga, st. Alexandra Chaka</p>
        </div>
        <br>
        <h2 class="emp-profile-title">> Working Hours</h2>
        <div class="emp-profile-divider"></div>
        <div class="emp-profile-contact-info">
            <p><span class="emp-profile-hours">Monday - Friday:</span> 9:00 AM - 6:00 PM</p>
            <p><span class="emp-profile-hours">Saturday:</span> 10:00 AM - 4:00 PM</p>
            <p><span class="emp-profile-hours">Sunday:</span> Closed</p>
        </div>

        <br>
        <h2 class="emp-profile-title">> Social Media</h2>
        <div class="emp-profile-divider"></div>
        <p><a href="#" class="social-link facebook">Facebook</a></p>
        <p><a href="#" class="social-link twitter">Twitter</a></p>
        <p><a href="#" class="social-link instagram">Instagram</a></p>

        <br>
        <h2 class="emp-profile-title">> Location on the map</h2>
        <div class="emp-profile-divider"></div>
        <div class="map-container" style="margin-top: 20px;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d543.936956951441!2d24.1044477!3d56.9531216!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2slv!4v1717096814705!5m2!1sen!2slv" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>