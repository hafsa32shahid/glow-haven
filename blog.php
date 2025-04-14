<?php
session_start();
require("./includes/header.php") ?>
<?php require("./includes/navbar.php") ?>

<!-- Blog Section -->
<section class="blog py-5" style="background: linear-gradient(135deg, #f9f9f9, #ffffff) !important;">
  <div class="container">
    <h2 class="text-center mb-4 logo-text animate__animated animate__fadeInDown" style="font-size:4rem;">Our Blog</h2>
    <p class="text-center mb-5 animate__animated animate__fadeInDown animate__delay-1s">Discover the latest trends, tips, and stories from Glow & Haven.</p>
    <div class="row">
      <!-- Blog Post 1 -->
      <div class="col-md-4 mb-4 animate__animated animate__fadeInUp">
        <div class="card shadow-sm">
          <img src="https://img.freepik.com/premium-photo/portrait-attractive-young-adult-woman-sitting-table-holding-various-make-up-brushes_236854-23005.jpg?ga=GA1.1.24328383.1694452068&semt=ais_hybrid" class="card-img-top" alt="Blog Post 1">
          <div class="card-body">
            <h5 class="card-title">Top 10 Beauty Trends for 2023</h5>
            <p class="card-text">Explore the hottest beauty trends that will dominate 2023. From glowing skin to bold lips, we've got you covered.</p>
            <!-- <a href="#" class="btn button">Read More</a> -->
          </div>
        </div>
      </div>
      <!-- Blog Post 2 -->
      <div class="col-md-4 mb-4 animate__animated animate__fadeInUp animate__delay-1s">
        <div class="card shadow-sm">
          <img src="https://img.freepik.com/free-photo/pleased-young-girl-holding-looking-mirror-applying-tone-up-cream-with-sponge-sitting-table-with-makeup-tools-living-room_141793-123360.jpg?ga=GA1.1.24328383.1694452068&semt=ais_hybrid" class="card-img-top" alt="Blog Post 2">
          <div class="card-body">
            <h5 class="card-title">How to Choose the Perfect Jewelry</h5>
            <p class="card-text">Learn how to select the perfect jewelry pieces to complement your style and enhance your natural beauty.</p>
          </div>
        </div>
      </div>
      <!-- Blog Post 3 -->
      <div class="col-md-4 mb-4 animate__animated animate__fadeInUp animate__delay-2s">
        <div class="card shadow-sm">
          <img src="https://img.freepik.com/free-photo/good-looking-woman-model-apron-holding-purple-onion_114579-36901.jpg?ga=GA1.1.24328383.1694452068&semt=ais_hybrid" class="card-img-top" alt="Blog Post 3">
          <div class="card-body">
            <h5 class="card-title">Skincare Routine for Glowing Skin</h5>
            <p class="card-text">Discover the ultimate skincare routine to achieve radiant and glowing skin all year round.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require("./includes/footer.php");
require("./includes/html-close.php");
?>