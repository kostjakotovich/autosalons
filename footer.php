<?php
require_once 'connection.php';
?>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/footers/">
  <link rel="stylesheet" href="css/footer.css">
  <!-- JSQuery Скрипт для плавной прокрутки страницы-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    $('a[href^="#"]').on('click', function(event) {
      var target = $(this.getAttribute('href'));
      if( target.length ) {
        event.preventDefault();
        $('html, body').stop().animate({
          scrollTop: target.offset().top
        }, 1000);
      }
    });
  });
</script>

  <br>
  <footer class="footer">
  <div class="container">
    <div class="footer-content">
      <div class="social-media">
        <h3>We are in social networks</h3>
        <ul>
          <li><a href="#">Facebook</a></li>
          <li><a href="#">Instagram</a></li>
          <li><a href="#">Twitter</a></li>
        </ul>
      </div>
      <div class="contact-info" id="about-us">
        <h3>Contact information</h3>
        <p>Address: 123456, city, Riga, st. Alexandra Chaka</p>
        <p>Telephone: +371 123-45-67</p>
        <p>Email: info@yoursalon.com</p>
      </div>
    </div>
    <div class="footer-bottom">
      <p>© 
        <script>document.write(new Date().getFullYear())</script> 
        The name of our dealership. All rights reserved.</p>
    </div>
  </div>
</footer>

