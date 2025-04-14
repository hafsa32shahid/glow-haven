<?php

include("./config/connection.php");
// Initialize $user_id to prevent errors
$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0; // Default to 0 or any fallback value

// Query for cart items (consider user_id = 0 if not logged in)
$cart = "SELECT id FROM cart WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $cart);

if ($result) {
    // Count the number of rows in the result set
    $item = mysqli_num_rows($result);
} else {
    // Handle SQL error
    echo "Error: " . mysqli_error($conn);
}
$query = $conn->prepare("SELECT f.product_id, f.product_type, 
       CASE WHEN f.product_type = 'cosmetics' THEN c.product_name ELSE j.product_name END AS product_name,
       CASE WHEN f.product_type = 'cosmetics' THEN c.product_image ELSE j.product_image END AS product_image
FROM favorites f
LEFT JOIN cosmet_products c ON f.product_id = c.id AND f.product_type = 'cosmetics'
LEFT JOIN jewelry_products j ON f.product_id = j.id AND f.product_type = 'jewelry'
WHERE f.user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$favorites = $query->get_result();

// Remove from Favorites
if (isset($_POST['remove_favorite'])) {
  $user_id = $_SESSION['id'];
  $product_id = $_POST['product_id'];
  $category = $_POST['category'];

  $stmt = $conn->prepare("DELETE FROM favorites WHERE user_id = ? AND product_id = ? AND product_type = ?");
  $stmt->bind_param("iis", $user_id, $product_id, $category);
  $stmt->execute();
  $stmt->close();

  header("Location: " . $_SERVER['HTTP_REFERER']);
  exit;
}
$query->close();
?>



<!-- ======================= HEADER ======================= -->

<!-- nav baner -->
<nav class="navbar px-4" style="background-color: #eb3477">
  <div class="container-fluid">
    <!-- My Account or Login Button -->
    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === TRUE): ?>
      <!-- My Account Button -->
      <a type="button" class="text-white d-xl-flex d-lg-flex d-sm-none acount1" data-bs-toggle="modal"
        data-bs-target="#accountModal">
        <i class="fa-solid fa-user me-2"></i> My Account
    </a>
      <?php else: ?>
        <!-- Login Button -->
        <a href="login.php" class="text-white d-xl-flex d-lg-flex d-sm-none acount1">
          <i class="fa-solid fa-user me-2"></i> Login
        </a>
      <?php endif; ?>


      <!-- Offer Text -->
      <p class="m-0 text-white fs-6 fw-bold mx-auto">
        🌸 Up to 50% OFF on Cosmetics & Jewelry 🌸
      </p>

      <!-- Social Media Links -->
      <ul
        class="navbar-nav media-links media-ban d-flex flex-row align-items-center gap-3 me-4 d-lg-flex d-md-none d-sm-none">
        <li class="nav-item ">
          <a class="nav-link text-white p-0 fs-4" href="#"><i class="fa-brands fa-square-facebook"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white p-0 fs-4" href="#"><i class="fa-brands fa-square-instagram"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white p-0 fs-4" href="#"><i class="fa-brands fa-square-twitter"></i></a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white p-0 fs-4" href="#"><i class="fa-brands fa-square-pinterest"></i></a>
        </li>
      </ul>
  </div>
</nav>

<!-- Modal for "My Account" -->
<div class="modal fade" id="accountModal" tabindex="-1" aria-labelledby="accountModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="accountModalLabel">My Account</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="mb-3"><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
        <a href="./pages/logout.php" class="btn button w-100 text-center">Logout</a>
      </div>
    </div>
  </div>
</div>

<!-- navbar  -->
<nav class="navbar navbar-expand-lg sticky-top" style="background-color: white;">
  <div class="container-fluid">
    <a class="navbar-brand nav-logo mt-0" href="#">
      <img src="./assets/logo-img/logo4.png" class="w-100" alt="">
    </a>

    <nav class="navbar navbar-expand-lg d-md-none">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0 mx-auto">
            <li class="nav-item mx-2 text-sm-center fw-normal">
              <a class="nav-link txt-nav active" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item mx-2 text-sm-center fw-normal">
              <a class="nav-link txt-nav " href="#">All Products</a>
            </li>

            <!-- mega dropdown dropdown -->
            <li class="nav-item mx-2 dropdown position-static text-sm-center fs-6 fw-normal">
              <a class="nav-link dropdown-toggle txt-nav" href="#" id="navbarDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                cosmetics
              </a>
              <div class="dropdown-menu w-100  border-0" aria-labelledby="navbarDropdown">
                <div class="container">
                  <div class="row my-4">
                    <div class="col-md-4 col-xl-2 col-lg-2 col-sm-6 mb-3 mb-xl-0">
                      <div class="pt-2">
                        <p class="text-uppercase fs-4 fw-bold">Trending</p>
                        <img
                          src="https://hudabeauty.com/on/demandware.static/-/Sites/default/dw5e8664b5/images/shade_finder_nav.jpg"
                          class="img-fluid rounded mb-3" alt="Category Image" />
                        <a href="#" class="text-body">
                          <p class="fs-6 fw-medium">
                            "Flawless, long-lasting coverage with our trending foundation for radiant, natural beauty."
                          </p>
                        </a>
                      </div>
                    </div>
                    <div class="col-md-4 col-xl-2 col-lg-2 col-sm-6 mb-3 mb-xl-0">
                      <div class="pt-2">
                        <p class="text-uppercase fs-4 fw-bold">Face</p>
                        <ul class="list-unstyled">
                          <li class="list-group-item my-2"><a href="#">Foundation</a></li>
                          <li class="list-group-item my-2"><a href="#">Concealer</a></li>
                          <li class="list-group-item my-2"><a href="#">Blush</a></li>
                          <li class="list-group-item my-2"><a href="#">Highlighter</a></li>
                          <li class="list-group-item my-2"><a href="#">Primer</a></li>
                          <li class="list-group-item my-2"><a href="#">Contour Products</a></li>
                          <li class="list-group-item my-2"><a href="#">Setting Powder/Spray</a></li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-md-4 col-xl-2 col-lg-2 col-sm-6 mb-3 mb-xl-0">
                      <div class="pt-2">
                        <p class="text-uppercase fs-4 fw-bold">Eyes</p>
                        <ul class="list-unstyled">
                          <li class="list-group-item my-2"><a href="#">Eyeshadow</a></li>
                          <li class="list-group-item my-2"><a href="#">Mascara</a></li>
                          <li class="list-group-item my-2"><a href="#">Eyeliner</a></li>
                          <li class="list-group-item my-2"><a href="#">Eyebrow Products</a></li>
                          <li class="list-group-item my-2"><a href="#">False Eyelashes</a></li>

                        </ul>
                      </div>
                    </div>
                    <div class="col-md-4 col-xl-2 col-lg-2 col-sm-6  mb-3 mb-xl-0">
                      <div class="pt-2">
                        <p class="text-uppercase fs-4 fw-bold">Lips</p>
                        <ul class="list-unstyled">
                          <li class="list-group-item my-2"><a href="#">Lipstick</a></li>
                          <li class="list-group-item my-2"><a href="#">Lip Gloss</a></li>
                          <li class="list-group-item my-2"><a href="#">Lip Balm</a></li>
                          <li class="list-group-item my-2"><a href="#">Lip Liner</a></li>

                        </ul>
                        <p class="text-uppercase fs-4 fw-bold mt-5"> Nails</p>
                        <ul class="list-unstyled">
                          <li class="list-group-item my-2"><a href="#">Nail Polish</a></li>
                          <li class="list-group-item my-2"><a href="#">Nail Tools</a></li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-md-4 col-xl-2 col-lg-2 col-sm-6 mb-3 mb-xl-0">
                      <div class="pt-2">
                        <p class="text-uppercase fs-4 fw-bold">Tools</p>
                        <ul class="list-unstyled">
                          <li class="list-group-item my-2"><a href="#">Brushes</a></li>
                          <li class="list-group-item my-2"><a href="#">Sponges</a></li>
                          <li class="list-group-item my-2"><a href="#">Makeup Bags</a></li>
                        </ul>
                        <p class="text-uppercase fs-4 fw-bold mt-5">Body</p>
                        <ul class="list-unstyled">
                          <li class="list-group-item my-2"><a href="#">Body Lotion</a></li>
                          <li class="list-group-item my-2"><a href="#">Body Wash</a></li>
                          <li class="list-group-item my-2"><a href="#">Body Oil</a></li>
                        </ul>
                      </div>
                    </div>
                    <div class="col-md-4 col-xl-2 col-lg-2 col-sm-6 mb-3 mb-xl-0">
                      <div class="pt-2">
                        <p class="text-uppercase fs-4 fw-bold">Skincare</p>
                        <ul class="list-unstyled">
                          <li class="list-group-item my-2"><a href="#">Moisturizers</a></li>
                          <li class="list-group-item my-2"><a href="#">Face Serums</a></li>
                          <li class="list-group-item my-2"><a href="#">Face Masks</a></li>
                          <li class="list-group-item my-2"><a href="#">Cleansers</a></li>
                          <li class="list-group-item my-2"><a href="#">Toners</a></li>
                          <li class="list-group-item my-2"><a href="#">Exfoliators</a></li>
                          <li class="list-group-item my-2"><a href="#">Sunscreen</a></li>
                        </ul>
                      </div>
                    </div>

                  </div>
                </div>

              </div>
            </li>



            <!-- Mega Dropdown -->
            <li class="nav-item mx-2 dropdown text-sm-center fs-6 fw-normal">

              <a class="nav-link dropdown-toggle txt-nav" href="#" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Jewelry Categories
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Necklaces</a></li>
                <li><a class="dropdown-item" href="#">Rings</a></li>
                <li><a class="dropdown-item" href="">Bracelets</a></li>
                <li><a class="dropdown-item" href="#">Earrings</a></li>
                <li><a class="dropdown-item" href="#">Anklets</a></li>
                <li><a class="dropdown-item" href="#">Brooches</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Custom Jewelry</a></li>
              </ul>
            </li>

            <li class="nav-item mx-2 text-sm-center fs-6 fw-normal">
              <a class="nav-link txt-nav" href="#">Best Selling</a>
            </li>

            <li class="nav-item mx-2 text-sm-center fs-6 fw-normal">
              <a class="nav-link txt-nav" href="#">Contact Us</a>
            </li>

            <li class="nav-item mx-2 text-sm-center fs-6 fw-normal">
              <a class="nav-link txt-nav" href="#">About Us</a>
            </li>
          </ul>
          <!-- my account btn -->
          <!-- <a href="" class=" d-xl-none d-lg-none d-md-none d-sm-none acount2"><i class="fa-solid fa-user"></i> My Account</button></a> -->
          <ul
            class="navbar-nav media-links d-flex flex-row align-items-center gap-3 me-4 d-lg-none d-md-none d-sm-none">
            <li class="nav-item ">
              <a class="nav-link text-white p-0 fs-4" href="#"><i class="fa-brands fa-square-facebook"></i></a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white p-0 fs-4" href="#"><i class="fa-brands fa-square-instagram"></i></a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white p-0 fs-4" href="#"><i class="fa-brands fa-square-twitter"></i></a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-white p-0 fs-4" href="#"><i class="fa-brands fa-square-pinterest"></i></a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- sidebar menu -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">

        <h1 class="offcanvas-header nav-logo" id="offcanvasNavbarLabel"><img src="./assets/logo-img/logo4.png"
            class="w-100" alt=""></h1>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item mx-2 text-sm-center fs-6 fw-normal">
            <a class="nav-link txt-nav active" aria-current="page" href="index.php">Home</a>
          </li>

          <hr class="border border-black d-xl-none d-lg-none d-md-block ">
          <li class="nav-item mx-2 text-sm-center fs-6 fw-normal">
            <a class="nav-link txt-nav" href="all-products.php">All Products</a>
          </li>
          <hr class="border border-black d-xl-none d-lg-none d-md-block ">
          <!-- mega dropdown dropdown -->
          <li class="nav-item mx-2 dropdown position-static text-sm-center fs-6 fw-normal">
            <a class="nav-link dropdown-toggle txt-nav" href="#" id="navbarDropdown" role="button"
              data-bs-toggle="dropdown" aria-expanded="false">
              cosmetics
            </a>
            <div class="dropdown-menu w-100  border-0" aria-labelledby="navbarDropdown">
              <div class="container">
                <div class="row my-4">
                  <div class="col-md-4 col-xl-2 col-lg-2 col-sm-6 mb-3 mb-xl-0">
                    <div class="pt-2">
                      <p class="text-uppercase fs-4 fw-bold">Trending</p>
                      <img
                        src="https://hudabeauty.com/on/demandware.static/-/Sites/default/dw5e8664b5/images/shade_finder_nav.jpg"
                        class="img-fluid rounded mb-3" alt="Category Image" />
                      <a href="all-products.php" class="text-body">
                        <p class="fs-6 fw-medium">
                          "Flawless, long-lasting coverage with our trending foundation for radiant, natural beauty."
                        </p>
                      </a>
                    </div>
                  </div>
                  <div class="col-md-4 col-xl-2 col-lg-2 col-sm-6 mb-3 mb-xl-0">
                    <div class="pt-2">
                      <p class="text-uppercase fs-4 fw-bold">Face</p>
                      <ul class="list-unstyled">
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=1">Foundation</a>
                        </li>
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=2">Concealer</a>
                        </li>
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=4">Blush</a></li>
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=5">Highlighter</a></li>
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=6">Primer</a></li>
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=7">Contour Products</a></li>
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=34">Setting Powder/Spray</a></li>
                      </ul>
                    </div>
                  </div>
                  <div class="col-md-4 col-xl-2 col-lg-2 col-sm-6 mb-3 mb-xl-0">
                    <div class="pt-2">
                      <p class="text-uppercase fs-4 fw-bold">Eyes</p>
                      <ul class="list-unstyled">
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=8">Eyeshadow</a></li>
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=3">Mascara</a></li>
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=9">Eyeliner</a></li>
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=12">Eyebrow Products</a></li>
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=13">False Eyelashes</a></li>

                      </ul>
                    </div>
                  </div>
                  <div class="col-md-4 col-xl-2 col-lg-2 col-sm-6  mb-3 mb-xl-0">
                    <div class="pt-2">
                      <p class="text-uppercase fs-4 fw-bold">Lips</p>
                      <ul class="list-unstyled">
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=14">Lipstick</a></li>
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=15">Lip Gloss</a></li>
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=16">Lip Balm</a></li>
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=18">Lip Liner</a></li>

                      </ul>
                      <p class="text-uppercase fs-4 fw-bold"> Nails</p>
                      <ul class="list-unstyled">
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=19">Nail Polish</a></li>
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=20">Nail Tools</a></li>
                      </ul>
                    </div>
                  </div>
                  <div class="col-md-4 col-xl-2 col-lg-2 col-sm-6 mb-3 mb-xl-0">
                    <div class="pt-2">
                      <p class="text-uppercase fs-4 fw-bold">Tools</p>
                      <ul class="list-unstyled">
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=21">Brushes</a></li>
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=22">Sponges</a></li>
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=23">Makeup Bags</a></li>
                      </ul>
                      <p class="text-uppercase fs-4 fw-bold">Body</p>
                      <ul class="list-unstyled">
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=24">Body Lotion</a></li>
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=25">Body Wash</a></li>
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=26">Body Oil</a></li>
                      </ul>
                    </div>
                  </div>
                  <div class="col-md-4 col-xl-2 col-lg-2 col-sm-6 mb-3 mb-xl-0">
                    <div class="pt-2">
                      <p class="text-uppercase fs-4 fw-bold">Skincare</p>
                      <ul class="list-unstyled">
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=27">Moisturizers</a></li>
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=28">Face Serums</a></li>
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=29">Face Masks</a></li>
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=30">Cleansers</a></li>
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=31">Toners</a></li>
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=32">Exfoliators</a></li>
                        <li class="list-group-item my-2"><a href="face-foundation.php?subcategory_id=33">Sunscreen</a></li>
                      </ul>
                    </div>
                  </div>

                </div>
              </div>

            </div>
          </li>


          <hr class="border border-black d-xl-none d-lg-none d-md-block ">
          <!-- Mega Dropdown -->
          <li class="nav-item dropdown text-sm-center fs-6 fw-normal">
            <a class="nav-link dropdown-toggle txt-nav" href="#" role="button" data-bs-toggle="dropdown"
              aria-expanded="false">
              Jewelry Categories
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="jewe-products.php?category_id=3"><i
                    class="fa-solid fa-gem me-2"></i>Necklaces</a></li>
              <li><a class="dropdown-item" href="jewe-products.php?category_id=4"><i class="fa-solid fa-ring me-2"></i>Rings</a></li>
              <li><a class="dropdown-item" href="jewe-products.php?category_id=2"> <i
                    class="fa-solid fa-link me-2"></i>Bracelets</a></li>
              <li><a class="dropdown-item" href="jewe-products.php?category_id=1"><i
                    class="fa-solid fa-earring me-2"></i>Earrings</a></li>
              <li><a class="dropdown-item" href="jewe-products.php?category_id=6"> <i class="fa-solid fa-shoe-prints me-2"></i>Anklets</a></li>
              <li><a class="dropdown-item" href="jewe-products.php?category_id=7"><i class="fa-solid fa-star me-2"></i>Brooches</a></li>
            </ul>
          </li>
          <hr class="border border-black d-xl-none d-lg-none d-md-block ">
          <li class="nav-item mx-2 text-sm-center fs-6 fw-normal">
            <a class="nav-link txt-nav" href="top-10products.php">Best Selling</a>
          </li>
          <hr class="border border-black d-xl-none d-lg-none d-md-block ">
          <li class="nav-item mx-2 text-sm-center fs-6 fw-normal">
            <a class="nav-link txt-nav" href="contact-us.php">Contact Us</a>
          </li>
          <hr class="border border-black d-xl-none d-lg-none d-md-block ">
          <li class="nav-item mx-2 text-sm-center fs-6 fw-normal">
            <a class="nav-link txt-nav" href="about-us.php">About Us</a>
          </li>

        </ul>
        <!-- my account btn -->
        <a href="login.php"
          class="offcanvas-bottom text-black d-xl-none d-lg-none acount position-absolute bottom-0 mb-3 fs-4"><i
            class="fa-solid fa-user"></i> My Account</button></a>
        <!-- Social Media Links -->
        <ul
          class="navbar-nav position-absolute mb-3 end-0 bottom-0 media-links d-flex flex-row align-items-center gap-3 me-4 d-lg-none d-md-flex d-sm-flex">
          <li class="nav-item ">
            <a class="nav-link p-0 fs-4" href="#"><i class="fa-brands fa-square-facebook"></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link p-0 fs-4" href="#"><i class="fa-brands fa-square-instagram"></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link p-0 fs-4" href="#"><i class="fa-brands fa-square-twitter"></i></a>
          </li>
          <li class="nav-item">
            <a class="nav-link p-0 fs-4" href="#"><i class="fa-brands fa-square-pinterest"></i></a>
          </li>
        </ul>
      </div>
    </div>
    <form class="d-flex flex-wrap align-items-center justify-content-between text-black">
      <!-- Search Button -->
      <button class="btn border-0 d-flex align-items-center justify-content-center" type="button" data-bs-toggle="modal"
        data-bs-target="#searchModal">
        <i class="fa-solid fa-magnifying-glass mx-2 fs-5"></i>
      </button>

      <!-- Trigger for Favorite List Modal -->
      <a type="button" class="d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#favouriteItemModal">
        <i class="fa-regular fa-heart mx-2 fs-5"></i>
      </a>


      <!-- Cart Icon -->
      <a href="cart.php" class="d-flex align-items-center position-relative">
        <i class="fa-solid fa-cart-shopping mx-2 fs-5"></i>
        <!-- Cart count badge -->
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
          <?php echo $item; ?>
        </span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
        aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </form>


  </div>
  </div>
</nav>
<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="searchModalLabel">Search</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Search Form -->

        <div class="input-group w-lg-75 w-md-100 shadow-sm mx-auto">
          <input id="searchInput" name="query" class="form-control input shadow-none rounded-start ps-3" type="search"
            placeholder="Search..." aria-label="Search" />
          <button id="btn_search" class="btn button rounded-end px-4" type="submit">Search</button>
        </div>

        <ul id="searchResult" class="list-unstyled">

        </ul>
      </div>
    </div>
  </div>
</div>
<!-- favourite Modal -->
<!-- Modal for Favorite List -->
<div class="modal fade" id="favouriteItemModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="favouriteItemLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="favouriteItemLabel">Your Favorite Products</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="list-group">
        <?php if ($favorites->num_rows > 0): ?>
            <?php while ($row = $favorites->fetch_assoc()): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                  <img src="./admin/<?= htmlspecialchars($row['product_image']) ?>" alt="Product Image" class="img-thumbnail me-3" style="width: 50px; height: 50px;">
                  <div>
                    <h6 class="mb-0"><?= htmlspecialchars($row['product_name']) ?></h6>
                  </div>
                </div>
                <form method="post" action="" style="margin:0;">
                  <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                  <input type="hidden" name="category" value="<?= $row['product_type'] ?>">
                  <button type="submit" name="remove_favorite" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash"></i> Remove</button>
                </form>
              </li>
            <?php endwhile; ?>
          <?php else: ?>
            <li class="list-group-item text-center">No favorites added yet.</li>
          <?php endif; ?>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
  integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
  $(document).ready(function () {
    $("#btn_search").click(function () {
      var search_item = $("#searchInput").val();
      $.ajax({
        url: "search-result.php",
        type: "POST",
        data: { search: search_item },
        success: function (data) {
          $("#searchResult").html(data);
        }
      })
    })
  })
</script>