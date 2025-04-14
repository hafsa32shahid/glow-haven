<?php
session_start();
require("./includes/header.php") ?>
<?php require("./includes/navbar.php") ?>
 <!-- About Us Section -->
 <section class="about-us py-5" style=" background: linear-gradient(135deg, #f9f9f9, #ffffff) !important;">
 <h2 class="text-center mb-4 logo-text" style="font-size:4rem;">About Us</h2>
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <h1 class="display-4 fw-bold animate__animated animate__fadeInLeft">About Glow & Haven</h1>
          <p class="lead p animate__animated animate__fadeInLeft animate__delay-1s">
            At Glow & Haven, we believe in the power of beauty and elegance. Our mission is to provide you with the finest cosmetics and jewelry that enhance your natural glow and make you feel confident and radiant.
          </p>
          <p class="p animate__animated animate__fadeInLeft animate__delay-2s">
            Founded in 2023, Glow & Haven has quickly become a trusted name in the beauty and jewelry industry. We carefully curate our collections to ensure that every product meets the highest standards of quality and craftsmanship.
          </p>
          <a href="all-products.php" class="btn btn-lg mt-3 animate__animated animate__fadeInUp animate__delay-3s w-auto" style="background-color: #eb3477; color: white;">Explore Our Collections</a>
        </div>
        <div class="col-lg-6">
          <img src="https://img.freepik.com/premium-photo/inside-store-with-large-mirror-large-mirror_1025753-202072.jpg?ga=GA1.1.24328383.1694452068&semt=ais_hybrid" alt="About Us" class="img-fluid rounded shadow animate__animated animate__fadeInRight animate__delay-1s">
        </div>
      </div>
    </div>
  </section>

  <!-- Our Values Section -->
  <section class="our-values py-5 bg-light">
    <div class="container">
      <h2 class="text-center mb-5 animate__animated animate__fadeInDown">Our Values</h2>
      <div class="row text-center">
        <div class="col-md-4 mt-md-3 animate__animated animate__fadeInUp animate__delay-1s">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <i class="fas fa-gem fa-3x mb-3 text-primary"></i>
              <h5 class="card-title">Quality</h5>
              <p class="card-text">We source only the finest materials to ensure our products are of the highest quality.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mt-md-3 animate__animated animate__fadeInUp animate__delay-2s">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <i class="fas fa-heart fa-3x mb-3 text-danger"></i>
              <h5 class="card-title">Passion</h5>
              <p class="card-text">Our team is passionate about creating products that inspire confidence and beauty.</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mt-md-3 animate__animated animate__fadeInUp animate__delay-3s">
          <div class="card border-0 shadow-sm">
            <div class="card-body">
              <i class="fas fa-users fa-3x mb-3 text-success"></i>
              <h5 class="card-title">Community</h5>
              <p class="card-text">We believe in building a community that celebrates individuality and self-expression.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php 
 require("./includes/footer.php");
 require("./includes/html-close.php");
 ?>