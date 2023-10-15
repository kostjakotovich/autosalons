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
    <div class="info-container">
        <div class="info-header" onclick="toggleInfo('section1')">О нас</div>
        <div class="info-content" id="section1">
            <p>Мы - компания, занимающаяся предоставлением услуг по разработке веб-сайтов и веб-приложений. Наша команда опытных специалистов готова помочь вам воплотить ваши идеи в реальность.</p>
        </div>

        <div class="info-header" onclick="toggleInfo('section2')">Услуги</div>
        <div class="info-content" id="section2">
            <p>Мы предоставляем широкий спектр услуг, включая веб-дизайн, разработку, оптимизацию и поддержку веб-проектов. Мы заботимся о вашем успехе в онлайн-мире.</p>
        </div>

        <div class="info-header" onclick="toggleInfo('section3')">Контакты</div>
        <div class="info-content" id="section3">
            <p>Если у вас есть вопросы или вам нужна дополнительная информация, пожалуйста, свяжитесь с нами. Мы всегда готовы ответить на ваши запросы.</p>
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