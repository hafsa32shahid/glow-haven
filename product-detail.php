<?php include("./includes/header.php") ?>
<?php session_start(); ?>
<?php
include("./config/connection.php");

// Check if product_id is provided
if (!isset($_GET['product_id']) || !is_numeric($_GET['product_id'])) {
    die("<p class='text-danger'>Product ID not provided or invalid.</p>");
}

$product_id = intval($_GET['product_id']); // Sanitize input

// Fetch product details
$sql = "SELECT p.id, p.product_name, p.product_price, p.product_image, p.subcategory_id, 
               s.subcategory_name, s.disc
        FROM cosmet_products p
        INNER JOIN cosm_subcategories s ON p.subcategory_id = s.id
        WHERE p.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

// If product not found, stop execution
if (!$product) {
    die("<p class='text-danger'>Product not found.</p>");
}

// Fetch shades for the product
$shades = [];
$shade_sql = "SELECT shade_name, shade_image FROM shades WHERE product_id = ?";
$shade_stmt = $conn->prepare($shade_sql);
$shade_stmt->bind_param("i", $product_id);
$shade_stmt->execute();
$shade_result = $shade_stmt->get_result();
if ($shade_result->num_rows > 0) {
    $shades = $shade_result->fetch_all(MYSQLI_ASSOC);
}
$shade_stmt->close();

// Fetch category safely
$category = isset($_GET['category']) ? htmlspecialchars($_GET['category']) : '';

// Fetch reviews based on category-based rating
$reviews = [];
if ($category) {
    $review_sql = "SELECT full_name, rating, id, reviews
                   FROM product_reviews 
                   WHERE product_id = ? AND category = ? 
                   ORDER BY rating DESC";

    $review_stmt = $conn->prepare($review_sql);
    $review_stmt->bind_param("is", $product_id, $category);
    $review_stmt->execute();
    $review_result = $review_stmt->get_result();
    if ($review_result->num_rows > 0) {
        $reviews = $review_result->fetch_all(MYSQLI_ASSOC);
    }
    $review_stmt->close();
}

// Fetch related products (based on subcategory)
$related_products = [];
if (!empty($product['subcategory_id'])) {
    $related_products_sql = "SELECT id, product_name, product_price, product_image 
                             FROM cosmet_products 
                             WHERE subcategory_id = ? AND id != ? 
                             LIMIT 6";

    $related_stmt = $conn->prepare($related_products_sql);
    $related_stmt->bind_param("ii", $product['subcategory_id'], $product_id);
    $related_stmt->execute();
    $related_result = $related_stmt->get_result();
    if ($related_result->num_rows > 0) {
        $related_products = $related_result->fetch_all(MYSQLI_ASSOC);
    }
    $related_stmt->close();
}
?>

<?php
// Get product price from product array
$product_p = $product['product_price'];

if (isset($_POST['add-to-cart'])) {

    // Check if the user is logged in
    if (!isset($_SESSION['id'])) {
        echo '<script>
              Swal.fire({
                  title: "Login Required!",
                  text: "Please log in to add products to your cart.",
                  icon: "info",
                  confirmButtonText: "Login"
              }).then(() => {
                  window.location.href = "./login.php";
              });
          </script>';
        exit;
    }

    // Retrieve form data
    $user_id = $_SESSION['id']; 
    $product_id = $_POST['product_id']; // Ensure this exists in your form
    $product_name = $_POST['pname'];
    $product_price = $product_p;
    $product_image = $_POST['pimage'];
    $product_shade = $_POST['shade'] ?? NULL; // Handle NULL case
    $quantity = $_POST['quantity'];
    $product_type = $_POST['product_type']; 

    // Check if the product already exists in the cart
    if (!empty($product_shade)) {
        $alr_selected = "SELECT * FROM cart WHERE user_id = ? AND product_id = ? AND product_type = ? AND product_shade = ?";
        $alr_select = $conn->prepare($alr_selected);
        $alr_select->bind_param("iiss", $user_id, $product_id, $product_type, $product_shade);
    } else {
        $alr_selected = "SELECT * FROM cart WHERE user_id = ? AND product_id = ? AND product_type = ?";
        $alr_select = $conn->prepare($alr_selected);
        $alr_select->bind_param("iis", $user_id, $product_id, $product_type);
    }

    $alr_select->execute();
    $alr_result = $alr_select->get_result();

    if ($alr_result->num_rows > 0) {
        // Product already exists in the cart
        echo '<script>
              Swal.fire({
                  title: "Warning!",
                  text: "Product already exists in the cart.",
                  icon: "warning",
                  confirmButtonText: "OK"
              });
          </script>';
    } else {
        // Insert the product into the cart
        $cart = "INSERT INTO cart (user_id, product_id, product_name, product_price, product_image, product_shade, quantity, product_type)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $cart_stmt = $conn->prepare($cart);

        // Handle NULL values correctly
        $cart_stmt->bind_param("iissssis", $user_id, $product_id, $product_name, $product_price, $product_image, $product_shade, $quantity, $product_type);

        if ($cart_stmt->execute()) {
            echo '<script>
                  Swal.fire({
                      title: "Success!",
                      text: "Product added successfully.",
                      icon: "success",
                      confirmButtonText: "OK"
                  });
              </script>';
        } else {
            echo '<script>
                  Swal.fire({
                      title: "Error!",
                      text: "Error adding product to the cart.",
                      icon: "error",
                      confirmButtonText: "OK"
                  });
              </script>';
        }

        $cart_stmt->close();
    }
    $alr_select->close();
}
?>

<?php

// Add to Favorites
if (isset($_POST['add_to_favorite'])) {
     // Check if the user is logged in
     if (!isset($_SESSION['id'])) {
      echo '<script>
          Swal.fire({
              title: "Login Required!",
              text: "Please log in to add item to your favourite list.",
              icon: "info",
              confirmButtonText: "Login"
          }).then(() => {
              window.location.href = "./login.php"; // Redirect to login page
          });
      </script>';
      exit; // Stop further execution
    }

    $user_id = $_SESSION['id'];
    $product_id = $_POST['product_id'];
    $category = $_POST['product_type'];

    // Check if the product is already in favorites
    $check = $conn->prepare("SELECT id FROM favorites WHERE user_id = ? AND product_id = ? AND product_type = ?");
    $check->bind_param("iis", $user_id, $product_id, $category);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows === 0) {
        // Insert favorite item
        $stmt = $conn->prepare("INSERT INTO favorites (user_id, product_id, product_type) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $user_id, $product_id, $category);
        $stmt->execute();
        $stmt->close();

        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Added to Favorites',
                text: 'The product has been successfully added to your favorites!',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'info',
                title: 'Already in Favorites',
                text: 'This product is already in your favorites.',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '" . $_SERVER['HTTP_REFERER'] . "';
            });
        </script>";
    }
    $check->close();
    exit;
}
?>



<style>
  .swiper {
    width: 100%;
    height: 450px;
    margin-left: auto;
    margin-right: auto;
  }

  .swiper-slide {
    background-size: cover;
    background-position: center;
  }

  .mySwiper3 {
    width: 100%;
  }


  .swiper-slide img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .fa-star {
    font-size: 20px;
    /* Adjust the size as needed */
    color: #ccc;
    /* Default color for unselected stars */
  }

  .fa-star.checked {
    color: #ffc107;
    /* Yellow color for selected stars */
  }

  .rating {
    display: flex;
    align-items: center;
  }

  .rating span {
    margin-right: 5px;
    /* Add some spacing between stars */
  }

  .card-text {
    margin-top: 10px;
    font-size: 14px;
    color: #333;
    /* Adjust text color */
  }
</style>
</head>

<body>
  <?php include("./includes/navbar.php") ?>

  <div class="fluid_container">
    <div class="w-100" style="min-height: 120px;">
      <div class="collapse" id="collapseMessage">
        <div class="card card-body" style="position: absolute; top: 10px; left: 50%; transform: translateX(-50%);">
          This is some placeholder content for the message. It's hidden by default and shown when triggered.
        </div>
      </div>
    </div>
    <div class="row p-4">
      <div class="col-lg-5 col-md-4 col-sm-12">
        <!-- Upper Swiper -->
        <?php if ($product): ?>
          <div class="swiper mySwiper2">
            <div class="swiper-wrapper">
              <!-- Main product image -->
              <div class="swiper-slide">
                <img src='./admin/<?php echo $product['product_image']; ?>' alt="Main Product Image" />
              </div>
              <!-- Add shade images to the upper swiper -->
              <?php if ($shades): ?>
                <?php foreach ($shades as $shade): ?>
                  <div class="swiper-slide">
                    <img src="./admin/<?php echo $shade['shade_image']; ?>" alt="<?php echo $shade['shade_name']; ?>" />
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
        <?php else: ?>
          <p class="text-warning">Product not found.</p>
        <?php endif; ?>
      </div>
      <div class="col-lg-7 col-md-8 col-sm-12">
        <div class="p-3 text-lg-start text-sm-center">
          <div class="pro-name m-4 ms-0">
            <h1 class="fs-1 fw-bold"><?php echo htmlspecialchars($product['product_name']); ?></h1>
          </div>
          <?php


          // Calculate total number of reviews
          $total_reviews = count($reviews);

          // Calculate average rating
          $total_rating = 0;
          foreach ($reviews as $review) {
            $total_rating += $review['rating'];
          }
          $average_rating = $total_reviews > 0 ? $total_rating / $total_reviews : 0;
          ?>

          <?php if (!empty($reviews)): ?>
            <div class="row">
              <div class="col-12 mb-4">
                <div class="card shadow-none border-0">
                  <div class="card-body">
                    <h5 class="card-title">Rating</h5>
                    <div class="rating mb-2">
                      <?php for ($i = 1; $i <= 5; $i++): ?>
                        <span class="fa fa-star <?php echo ($i <= $average_rating) ? 'checked' : ''; ?>"></span>
                      <?php endfor; ?>
                      <span class="ml-2">(<?php echo round($average_rating, 1); ?>)</span>
                    </div>
                    <p class="card-text">Total Reviews: <?php echo $total_reviews; ?></p>
                  </div>
                </div>
              </div>
            </div>
          <?php else: ?>
            <p class="text-center text-muted">No reviews yet. Be the first to write one!</p>
          <?php endif; ?>

          <div class="pro-disc">
            <p class="fw-light">
              <?php echo htmlspecialchars($product['disc']); ?>
            </p>
          </div>
          <?php echo "Rs: <span class='fw-bold text-dark'>" . number_format($product_p, 2) . "</span>";
          ?>
        </div>


        <div class="pro-buttons ms-lg-3 ms-md-0">
          <form method="post">
            <div class="inputs d-flex align-content-center mt-3 gap-4">
              <?php if (!empty($shades)): ?>
                <div class="select-shade w-25">
                  <label for="shade-select" class="form-label">Select Shade</label><br>
                  <select name="shade" class="form-select" id="shade-select">
                    <option value="">Select Shade</option>
                    <?php foreach ($shades as $shade): ?>
                      <option value="<?php echo htmlspecialchars($shade['shade_name']); ?>">
                        <?php echo htmlspecialchars($shade['shade_name']); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              <?php else: ?>
                <!-- Optional: Placeholder or message if no shades are available -->
                <div class="select-shade w-auto mx-lg-0 mx-sm-auto">
                  <label for="shade-select" class="form-label">Select Shade</label><br>
                  <select name="shade" class="form-select" id="shade-select">
                    <option value="Default">Default</option>
                  </select>
                </div>
              <?php endif; ?>
              <div class="quantity ">
                <label for="quantity" class="form-label">Quantity</label><br>
                <input type="number" class=" form-control" name="quantity" value="1"><br>
              </div>
            </div>

            <input type="hidden" name="pname" value="<?php echo htmlspecialchars($product['product_name']); ?>">
            <input type="hidden" name="pprice" value="<?php echo number_format($product['product_price']); ?>">
            <input type="hidden" name="pimage" value="<?php echo htmlspecialchars($product['product_image']); ?>">
            <input type="hidden" name="product_type" value="cosmetics">

            <div class="btn-div d-flex ms-0 align-items-center justify-content-between mt-4 w-50">
              <button class="btn button add-to-cart mx-2" name="add-to-cart" type="submit">
                Add to Cart
              </button>
              <!-- Add to Favorites Button -->
              <form method="post" class="d-inline">
                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                <input type="hidden" name="category" value="<?php echo $category; ?>">
                <button class="wishlist btn button mx-2" type="submit" name="add_to_favorite">
                  <i class="fa-solid fa-heart"></i>
                </button>
              </form>

            </div>

          </form>


        </div>
      </div>
    </div>
  </div>

  <div class="row my-5 p-5">
    <h2 class="text-start mb-4 logo-text " style="font-size:3.5rem;">You May Also Like</h2>
    <?php if (!empty($related_products)): ?>
    <div class="row">
        <?php foreach ($related_products as $related): ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card shadow-sm rounded-4 h-100">
                    <a href="product-detail.php?product_id=<?php echo $related['id']; ?>&category=cosmetics" 
                       class="card shadow-sm border-light text-decoration-none">
                        <img src="./admin/<?php echo htmlspecialchars($related['product_image']); ?>" 
                             class="card-img-top"
                             alt="<?php echo htmlspecialchars($related['product_name']); ?>" 
                             style="height: 220px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title">$<?php echo htmlspecialchars($related['product_price']); ?></h5>
                            <?php if (!empty($related['product_type'])): ?>
                                <p class="card-text text-muted"><?php echo ucfirst($related['product_type']); ?></p>
                            <?php endif; ?>
                        </div>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="text-muted">No related products found.</p>
<?php endif; ?>



  </div>
  <?php include("./includes/review.php") ?>
  </div>
  <?php include("./includes/footer.php") ?>

  <!-- Swiper JS -->
  <script>
    // Upper Swiper
    var swiperMain = new Swiper(".mySwiper2", {
      spaceBetween: 10,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      }
    });

  </script>
  <?php include("./includes/html-close.php") ?>