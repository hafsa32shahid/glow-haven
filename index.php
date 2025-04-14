<?php session_start(); ?>
<?php require("./includes/header.php") ?>
<?php
include("./config/connection.php");
?>
</head>

<body>
  <?php require("./includes/navbar.php") ?>
  <!-- ======================= Hero section ======================= -->

  <section class="hero-section">
    <div class="fluid-container px-4">
      <div class="row flex-lg-row flex-xl-row flex-md-column-reverse flex-sm-column-reverse align-items-center">
        <!-- Text Content -->
        <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 mt-md-5 mt-sm-5">
          <h1 class="cursor typewriter-animation">Embrace the Glow, <br> Discover Your Heaven</h1>
          <p class="text-center">Glow and Heaven brings you handcrafted creations that embody grace, beauty, and
            sophistication. Celebrate life’s precious moments with designs that truly shine.</p>
          <div class="d-flex gap-3 align-content-center justify-content-evenly">
            <a href="all-products.php" class="btn button shadow">Shop Now</a>
            <a href="about-us.php" class="btn secbtn shadow">About Us</a>
          </div>
        </div>

        <!-- Carousel -->
        <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12">
          <div class="swiper mySwiper">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <img
                  src="https://img.freepik.com/premium-photo/female-nacklace_752237-12245.jpg?ga=GA1.1.24328383.1694452068&semt=ais_hybrid"
                  class="w-100" />
              </div>
              <div class="swiper-slide">
                <img src="https://i.pinimg.com/474x/f9/81/99/f9819997ffe823b37a7b4d1c337995a4.jpg" class="w-100" />
              </div>
              <div class="swiper-slide">
                <img src="https://i.pinimg.com/474x/60/07/d1/6007d103fe797ea7325bd8eac4eae6b9.jpg" class="w-100" />
              </div>
              <div class="swiper-slide">
                <img src="https://i.pinimg.com/474x/d0/0b/0b/d00b0ba3054ca9ee63a8a9d3fd799b2d.jpg" class="w-100" />
              </div>
              <div class="swiper-slide">
                <img src="https://i.pinimg.com/474x/89/b1/2e/89b12e6c80d35dde760e1f596433ffb0.jpg" class="w-100" />
              </div>
              <div class="swiper-slide">
                <img src="https://i.pinimg.com/474x/1f/c9/d1/1fc9d1223c49c79d7278934b557ac07c.jpg" class="w-100" />
              </div>
              <div class="swiper-slide">
                <img src="https://i.pinimg.com/474x/5e/cb/3d/5ecb3d6fe07e9cf521ea7c72b00c5c2c.jpg" class="w-100" />
              </div>
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ======================= jewelery section ======================= -->

  <section class="jewelery-ban mt-5">
    <div class="fluid-container p-4">
      <h1 class="text-center logo-text mt-5" style="font-size: 6rem;">Jewelery section</h1>
      <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 p-5 text-center">
          <h2 class="fs-2 fw-bold mb-4">Our Jewelry</h2>
          <p class="fw-light my-4 lh-4">At Glow and Heaven, jewelry is more than an accessory—it’s a reflection of
            individuality, a symbol of cherished memories, and timeless artistry.
            Each piece blends tradition with modern elegance, crafted with passion and precision. From radiant gemstones
            to intricate designs, every creation tells a story of beauty and craftsmanship.
            We proudly embrace ethical sourcing and sustainable practices, ensuring each gem honors the earth and the
            artisans behind it.
            Discover jewelry that inspires, empowers, and becomes part of your journey. At Glow and Heaven, we craft
            connections that shine forever.
          </p>
          <a href="all-products.php" class="btn button mt-4">View More</a>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-0 mt-md-4 mt-sm-4">
          <div class="img-contain" style="width: 100%; height: 450px;">
            <img src="https://i.pinimg.com/474x/47/89/ff/4789ff9a8fb9abd84c42ec7e2de18a32.jpg" class="h-100 w-100"
              alt="">
          </div>
        </div>
      </div>

      <!-- New Section for Jewelry Cards -->
      <div class="row mt-5">
        <?php
        $query = "SELECT * FROM jewelry_products LIMIT 6";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
          echo '<div class="row mt-5">';
          while ($row = mysqli_fetch_assoc($result)) {
            // Generate each card dynamically
            echo '<div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                <a href="jewe-detail.php?product_id=' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . '&category_id= ' . htmlspecialchars($row['category_id'], ENT_QUOTES, 'UTF-8') . '&category=jewelry" class="card shadow-sm border-light text-decoration-none">
                  <img src="./admin/' . htmlspecialchars($row['product_image'], ENT_QUOTES, 'UTF-8') . '" class="card-img-top" alt="' . htmlspecialchars($row['product_name'], ENT_QUOTES, 'UTF-8') . '">
                  <div class="card-body text-center">
                    <h5 class="card-title">$' . htmlspecialchars($row['product_price'], ENT_QUOTES, 'UTF-8') . '</h5>
                  </div>
                </a>
              </div>';
          }
          echo '</div>';
        } else {
          echo "<p>No products found.</p>";
        }
        ?>
      </div>
    </div>
  </section>


  <!-- ======================= Makeup section ======================= -->
  <section class="makeup-ban mt-5">
    <div class="fluid-container p-4">
      <h1 class="text-center logo-text mt-5" style="font-size: 6rem;">Makeup section</h1>
      <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 p-5 text-center">
          <h2 class="fs-2 fw-bold mb-4">Our Jewelry</h2>
          <p class="fw-light my-4 lh-4">At Glow and Heaven, jewelry is more than an accessory—it’s a reflection of
            individuality, a symbol of cherished memories, and timeless artistry.
            Each piece blends tradition with modern elegance, crafted with passion and precision. From radiant gemstones
            to intricate designs, every creation tells a story of beauty and craftsmanship.
            We proudly embrace ethical sourcing and sustainable practices, ensuring each gem honors the earth and the
            artisans behind it.
            Discover jewelry that inspires, empowers, and becomes part of your journey. At Glow and Heaven, we craft
            connections that shine forever.
          </p>
          <a href="all-products.php" class="btn button mt-4">View More</a>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mt-0 mt-md-4 mt-sm-4">
          <div class="img-contain" style="width: 100%; height: 450px;">
            <img src="https://i.pinimg.com/474x/0e/82/cb/0e82cbfcfcda32f1a3970bdf6647dde9.jpg" class="h-100 w-100"
              alt="">
          </div>
        </div>
      </div>

      <!-- New Section for Jewelry Cards -->
      <div class="row mt-5">
        <?php
        $query = "SELECT * FROM cosmet_products LIMIT 6";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
          echo '<div class="row mt-5">';
          while ($row = mysqli_fetch_assoc($result)) {
            // Generate each card dynamically
            echo '<div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                <a href="product-detail.php?product_id=' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . '&category=cosmetics" class="card shadow-sm border-light text-decoration-none">
                  <img src="./admin/' . htmlspecialchars($row['product_image'], ENT_QUOTES, 'UTF-8') . '" class="card-img-top" alt="' . htmlspecialchars($row['product_name'], ENT_QUOTES, 'UTF-8') . '">
                  <div class="card-body text-center">
                    <h5 class="card-title">$' . htmlspecialchars($row['product_price'], ENT_QUOTES, 'UTF-8') . '</h5>
                  </div>
                </a>
              </div>';
          }
          echo '</div>';
        } else {
          echo "<p>No products found.</p>";
        }
        ?>


      </div>
    </div>
  </section>

  <!-- ======================= Best Selling Products Section ======================= -->
  <section class="best-selling-products mt-5">
    <div class="container p-4">
      <h1 class="text-center logo-text mt-5" style="font-size: 6rem;">Best Selling</h1>
      <div class="row">
        <?php include("./pages/top_products.php"); ?>

        <?php
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            // Set default image if not available
            $image = !empty($row['product_image']) ? $row['product_image'] : 'https://via.placeholder.com/200x200';
            $rating = $row['rating'];
            $reviews = $row['reviews_count'];
            $product_id = $row['id'];
            $product_name = $row['product_name'];
            $product_price = number_format($row['product_price'], 2);

            echo "
          <div class='col-lg-3 col-md-4 col-sm-6 mb-4'>
            <div class='card shadow-sm border-light'>
              <img src='./admin/$image' class='card-img-top' alt='{$row['product_name']}'>
              <div class='card-body text-center'>
                <h6>$product_name</h6>
                <h5 class='card-title'>$$product_price</h5>
                <div class='ratings mb-2'>
                  <span class='text-warning'>";

            // Generate star ratings dynamically
            for ($i = 1; $i <= 5; $i++) {
              if ($i <= $rating) {
                echo "<i class='fas fa-star'></i>";
              } elseif ($i - 0.5 == $rating) {
                echo "<i class='fas fa-star-half-alt'></i>";
              } else {
                echo "<i class='far fa-star'></i>";
              }
            }

            echo "</span>
                  <p class='text-muted'>($rating/5 - $reviews Reviews)</p>
                </div>";

            // **Dynamically set product detail page**
            if ($row['product_type'] === 'cosmetics') {
              echo "<a href='product-detail.php?product_id=$product_id&category=cosmetics' class='btn button'>View Details</a>";
            } else {
              echo "<a href='jewe-detail.php?product_id=$product_id&category_id={$row['category_id']}&category=jewelry' class='btn button'>View Details</a>";
            }

            echo "
              </div>
            </div>
          </div>";
          }
        } else {
          echo "<p class='text-danger'>No best-selling products available.</p>";
        }
        ?>
      </div>
      <a href="top-10products.php" class="button">View More</a>
    </div>
  </section>

  <section class="testimonials">
    <h1 class="text-center logo-text mt-5 mb-4" style="font-size: 6rem;">What Clients Say</h1>
    <div class="container py-5 d-flex justify-content-center align-items-center">
      <!-- Swiper -->
      <div class="swiper mySwiper2" style="max-width: 780px; width: 100%;">
        <div class="swiper-wrapper">
          <?php
          require("./config/connection.php");

          // Fetch the latest 6 reviews from the product_reviews table
          $review_query = "SELECT full_name, reviews FROM product_reviews ORDER BY created_at DESC LIMIT 6";
          $result = $conn->query($review_query);

          if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              ?>
              <!-- Testimonial Slide -->
              <div class="swiper-slide">
                <div class="testimonial-card">
                  <div class="testimonial-img mx-auto">
                    <img
                      src="https://img.freepik.com/free-photo/young-pretty-modern-muslim-woman-hijab-working-office-room-education-online_285396-9445.jpg"
                      alt="Client" class="testimonial-img">
                  </div>
                  <div class="content-test bg-white text-center rounded-5 p-4">
                    <h5 class="testimonial-name"><?php echo htmlspecialchars($row['full_name']); ?></h5>
                    <p class="testimonial-role">Customer</p>
                    <p class="testimonial-text">"<?php echo htmlspecialchars($row['reviews']); ?>"</p>
                  </div>
                </div>
              </div>
              <?php
            }
          } else {
            echo "<p class='text-center'>No reviews found.</p>";
          }
          ?>
        </div>
      </div>
    </div>
  </section>


  <!-- ======================= Offer  section ======================= -->

  <section class="offer-sec">
    <div class="fluid-container">
      <div class="video-wrapper w-100">
        <video autoplay muted loop class="background-video w-100 h-100">
          <source src="./assets/offer-vid.mp4" type="video/mp4">
          Your browser does not support the video tag.
        </video>
      </div>
    </div>
  </section>
  <?php include("./pages/contact.php"); ?>
  <!-- ======================= contact us  section ======================= -->
  <section class="contact-sec">
    <h1 class="text-center logo-text mt-5 mb-4" style="font-size: 6rem;">Get In Touch</h1>
    <div class="row">
      <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 ">
        <div class="map p-5">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3619.313992521744!2d67.14924997517532!3d24.887269144184664!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb339999415e0c3%3A0x36742eee0fd9c291!2sAptech%20Metro%20Star%20Gate!5e0!3m2!1sen!2s!4v1738165227337!5m2!1sen!2s"
            class="w-100" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
      <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 ">
        <div class="cont-form p-5">
          <form class="my-4" method="post" onsubmit="return validateForm()">
            <input class="form-control rounded-5 mx-2" type="text" name="name" id="name" placeholder="Name"
              required><br>
            <input class="form-control rounded-5 mx-2" type="email" name="email" id="email" placeholder="Email"
              required><br>
            <textarea class="form-control rounded-5 mx-2" name="message" id="message" rows="5" placeholder="Message"
              required></textarea>
            <button class="button btn my-5 ms-2" type="submit">Send Message</button>
          </form>
          <div id="error-message" class="text-danger"></div>
        </div>
      </div>
    </div>
  </section>

  <?php
      $conn->close();
  require("./includes/footer.php") ?>
  <script src="./js/validation.js"></script>
  <?php require("./includes/html-close.php") ?>