<?php
session_start();
require("./includes/header.php") ?>
<?php require("./includes/navbar.php") ?>

<?php
require("./config/connection.php"); // Database connection file
include("./pages/contact.php");

?>


 <!-- ======================= contact us  section ======================= -->
<!-- Contact Form Section -->
<section class="contact-sec">
    <h1 class="text-center logo-text mt-5 mb-4" style="font-size: 6rem;">Get In Touch</h1>
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <div class="map p-5">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3619.313992521744!2d67.14924997517532!3d24.887269144184664!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb339999415e0c3%3A0x36742eee0fd9c291!2sAptech%20Metro%20Star%20Gate!5e0!3m2!1sen!2s!4v1738165227337!5m2!1sen!2s" class="w-100" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <div class="cont-form p-5">
                <form class="my-4" method="post" onsubmit="return validateForm()">
                    <input class="form-control rounded-5 mx-2" type="text" name="name" id="name" placeholder="Name" required><br>
                    <input class="form-control rounded-5 mx-2" type="email" name="email" id="email" placeholder="Email" required><br>
                    <textarea class="form-control rounded-5 mx-2" name="message" id="message" rows="5" placeholder="Message" required></textarea>
                    <button class="button btn my-5 ms-2" type="submit">Send Message</button>
                </form>
                <div id="error-message" class="text-danger"></div>
            </div>
        </div>
    </div>
</section>


<!-- Contact Information Section -->
<section class="contact-info py-5 bg-light">
  <div class="container">
    <h2 class="text-center mb-5 animate__animated animate__fadeInDown">Get in Touch</h2>
    <div class="row text-center">
      <div class="col-md-4 animate__animated animate__fadeInUp animate__delay-1s">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <i class="fas fa-map-marker-alt fa-3x mb-3 text-primary"></i>
            <h5 class="card-title">Our Location</h5>
            <p class="card-text">Find Store: Store Locator</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 animate__animated animate__fadeInUp animate__delay-2s">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <i class="fas fa-phone-alt fa-3x mb-3 text-success"></i>
            <h5 class="card-title">Call Us</h5>
            <p class="card-text">+92 xxxxxxxxxxx</p>
          </div>
        </div>
      </div>
      <div class="col-md-4 animate__animated animate__fadeInUp animate__delay-3s">
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            <i class="fas fa-envelope fa-3x mb-3 text-danger"></i>
            <h5 class="card-title">Email Us</h5>
            <p class="card-text">info@glowandhaven.com</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="./js/validation.js"></script>
<?php require("./includes/footer.php");
require("./includes/html-close.php");
?>