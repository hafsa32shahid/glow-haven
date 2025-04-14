<?php
session_start();
require("./includes/header.php") ?>
<?php require("./includes/navbar.php") ?>

<!-- Header Section -->
<header class="bg-light py-5">
  <div class="container text-center">
  <h2 class="text-center mb-4 logo-text animate__animated animate__fadeInDown" style="font-size:5rem;">privacy policy</h2>
    <p class="text-muted">Your privacy is important to us. Learn how we collect, use, and protect your data.</p>
  </div>
</header>

<!-- Main Content Section -->
<section class="py-5">
  <div class="container">
    <div class="row">
      <!-- Section 1 -->
      <div class="col-md-12 mb-4">
        <h2 class="h4 fw-bold mb-3">1. Information We Collect</h2>
        <p>We collect information to provide better services to our users. This includes:</p>
        <ul class="list-unstyled">
          <li><i class="bi bi-check-circle text-success me-2"></i>Personal information like your name, email, and contact details.</li>
          <li><i class="bi bi-check-circle text-success me-2"></i>Browsing data such as IP addresses, browser type, and cookies.</li>
        </ul>
      </div>

      <!-- Section 2 -->
      <div class="col-md-12 mb-4">
        <h2 class="h4 fw-bold mb-3">2. How We Use Your Information</h2>
        <p>Your information is used to enhance your experience and improve our services. We may use your data for:</p>
        <ul class="list-unstyled">
          <li><i class="bi bi-check-circle text-success me-2"></i>Providing personalized content and recommendations.</li>
          <li><i class="bi bi-check-circle text-success me-2"></i>Processing transactions and communicating updates.</li>
        </ul>
      </div>

      <!-- Section 3 -->
      <div class="col-md-12 mb-4">
        <h2 class="h4 fw-bold mb-3">3. How We Protect Your Information</h2>
        <p>We implement advanced security measures to safeguard your data:</p>
        <ul class="list-unstyled">
          <li><i class="bi bi-check-circle text-success me-2"></i>Secure servers with encryption protocols.</li>
          <li><i class="bi bi-check-circle text-success me-2"></i>Regular updates to protect against vulnerabilities.</li>
        </ul>
      </div>

      <!-- Section 4 -->
      <div class="col-md-12 mb-4">
        <h2 class="h4 fw-bold mb-3">4. Sharing Your Information</h2>
        <p>We value your privacy and do not sell your personal information. We may share data only:</p>
        <ul class="list-unstyled">
          <li><i class="bi bi-check-circle text-success me-2"></i>With trusted third-party partners for service delivery.</li>
          <li><i class="bi bi-check-circle text-success me-2"></i>When required by law or to protect our rights.</li>
        </ul>
      </div>

      <!-- Section 5 -->
      <div class="col-md-12 mb-4">
        <h2 class="h4 fw-bold mb-3">5. Contact Us</h2>
        <p>If you have any questions about this privacy policy, please contact us at:</p>
        <ul class="list-unstyled">
          <li><i class="bi bi-envelope text-success me-2"></i>Email: support@glow&haven.com</li>
          <li><i class="bi bi-telephone text-success me-2"></i>Phone: +92 xxxxxxxxxxxx</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<?php require("./includes/footer.php") ?>
<?php require("./includes/html-close.php") ?>