<?php session_start(); ?>
<?php include("./includes/header.php") ?>
<?php
include("./config/connection.php");

// Check if product_id is provided
if (isset($_GET['product_id'])) {
  $product_id = intval($_GET['product_id']); // Sanitize input
} else {
  die("<p class='text-danger'>Product ID not provided.</p>");
}
if (isset($_GET['category_id'])) {
  $category_id = intval($_GET['category_id']); // Sanitize input
} else {
  die("<p class='text-danger'>Product ID not provided.</p>");
}
// Fetch product details (no subcategory, only category)
$sql = "SELECT p.id, p.product_name, p.product_price, p.product_image
        FROM jewelry_products p
        WHERE p.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
// pro disc
// Fetch the category description
$category_description_sql = "SELECT description
                              FROM jewelery_categories
                              WHERE id = ?";
$category_description_stmt = $conn->prepare($category_description_sql);
$category_description_stmt->bind_param("i", $category_id);
$category_description_stmt->execute();
$category_description_result = $category_description_stmt->get_result();
$category_description = $category_description_result->fetch_assoc();

$category = htmlspecialchars($_GET['category']);
// Fetch reviews based on category-based rating
$review_sql = "SELECT full_name, rating, id, reviews
               FROM product_reviews 
               WHERE product_id = ? AND category = ? 
               ORDER BY rating DESC"; // Sorting by highest rating first

$review_stmt = $conn->prepare($review_sql);
$review_stmt->bind_param("is", $product_id, $category);
$review_stmt->execute();
$review_result = $review_stmt->get_result();
$reviews = $review_result->fetch_all(MYSQLI_ASSOC);


$category_id = intval($_GET['category_id']);
// Fetch related products (based on category or any relevant criteria)
$related_products_sql = "SELECT id, product_name, product_price, product_image
                         FROM jewelry_products
                         WHERE category_id = ? AND id != ?
                         LIMIT 6"; // Adjust the limit as needed
$related_stmt = $conn->prepare($related_products_sql);
$related_stmt->bind_param("ii", $category_id, $product_id);
$related_stmt->execute();
$related_result = $related_stmt->get_result();
$related_products = $related_result->fetch_all(MYSQLI_ASSOC);
?>

<!-- add to cart -->


<?php


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
            window.location.href = "./login.php"; // Redirect to login page
        });
    </script>';
    exit; // Stop further execution
  }
  // Sanitize and validate input data
  $user_id = $_SESSION['id'];
  $product_name = htmlspecialchars($_POST['pname'], ENT_QUOTES, 'UTF-8');
  $product_price = $product_p;
  $product_image = htmlspecialchars($_POST['pimage'], ENT_QUOTES, 'UTF-8');
  $quantity = intval($_POST['quantity']);
  $product_type = htmlspecialchars($_POST['product_type'], ENT_QUOTES, 'UTF-8');
  $product_shade = isset($_POST['product_shade']) ? htmlspecialchars($_POST['product_shade'], ENT_QUOTES, 'UTF-8') : null;

  // Check if the product already exists in the cart
  $alr_selected = "SELECT * FROM cart WHERE product_id = ? AND product_type = ? AND  user_id = ?";
  $alr_select = $conn->prepare($alr_selected);

  if (!$alr_select) {
    die("Error preparing statement: " . $conn->error);
  }

  $alr_select->bind_param("isi", $product_id, $product_type, $user_id);
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
    $cart = "INSERT INTO cart (product_id, product_name, product_price, product_image, product_shade, quantity, product_type, user_id) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $cart_stmt = $conn->prepare($cart);

    if (!$cart_stmt) {
      die("Error preparing statement: " . $conn->error);
    }

    $cart_stmt->bind_param("issssisi", $product_id, $product_name, $product_price, $product_image, $product_shade, $quantity, $product_type, $user_id);


    if ($cart_stmt->execute()) {
      echo "<script>
      Swal.fire({
          title: 'Success!',
          text: 'Product added successfully.',
          icon: 'success',
          confirmButtonText: 'OK'
      })
  </script>";
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

// Add to Favorites
if (isset($_POST['add_to_favorite'])) {
   // Check if the user is logged in
   if (!isset($_SESSION['id'])) {
    echo '<script>
        Swal.fire({
            title: "Login Required!",
            text: "Please log in to add item to your favourite list..",
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
  /* Swiper styles */
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
    <div class="row p-4">
      <div class="col-lg-5 col-md-4 col-sm-12">
        <!-- Upper Swiper -->
        <?php if ($product): ?>
          <div class="swiper mySwiper2">
            <div class="swiper-wrapper">
              <!-- Main product image -->
              <div class="swiper-slide">
                <img src='./admin/<?php echo $product['product_image']; ?>' alt="Product Image" />
              </div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
          </div>
        <?php else: ?>
          <p class="text-warning">Product not found.</p>
        <?php endif; ?>
      </div>

      <div class="col-lg-7 col-md-8 col-sm-12col-7">
        <div class="p-3">
          <div class="pro-name m-4 ms-0">
            <h1 class="fs-1 fw-bold"><?php echo htmlspecialchars($product['product_name']); ?></h1>
          </div>

          <?php
          // Calculate total number of reviews
          $total_reviews = count($reviews);
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
            <p class="fw-light"><?php echo htmlspecialchars($category_description['description']); ?></p>
          </div>

          <div class="pro-price fs-3">
            Rs: <span class="fw-bold text-dark"><?php echo number_format($product['product_price']); ?></span>
          </div>

          <div class="pro-buttons d-flex align-content-center justify-content-between w-50 mt-4">
            <form method="post">
              <div class="inputs d-flex align-content-center mt-3 gap-4">

                <div class="quantity mx-lg-0 mx-sm-auto">
                  <label for="quantity" class="form-label">Quantity</label><br>
                  <input type="number" class=" form-control" name="quantity" value="1"><br>
                </div>
              </div>

              <input type="hidden" name="pname" value="<?php echo htmlspecialchars($product['product_name']); ?>">
              <input type="hidden" name="pprice" value="<?php echo number_format($product['product_price']); ?>">
              <input type="hidden" name="pimage" value="<?php echo htmlspecialchars($product['product_image']); ?>">
              <input type="hidden" name="product_type" value="jewelry">

              <div
                class="btn-div d-flex align-content-center justify-content-lg-between justify-content-sm-evenly w-lg-50 w-sm-100 mt-4">
                <button class="btn button add-to-cart" name="add-to-cart" type="submit" type="button"
                  data-bs-toggle="collapse" data-bs-target="#collapseMessage" aria-expanded="false"
                  aria-controls="collapseMessage">
                  Add to Cart</button>
                <!--- Add to Favorites Button -->
                <form method="post" class="d-inline">
                  <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                  <input type="hidden" name="category" value="<?php echo $category; ?>">
                  <button class="wishlist btn button mx-2" type="submit" name="add_to_favorite">
                    <i class="fa-solid fa-heart"></i>
                  </button>
                </form>
                <br>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="row my-5 p-5">
    <h2 class="text-start mb-4 logo-text" style="font-size:3.5rem;">You May Also Like</h2>
    <?php if (!empty($related_products)): ?>
        <?php foreach ($related_products as $related): ?>
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4 d-flex align-items-stretch"> <!-- Flexbox ensures equal height -->
                <div class="card shadow-sm rounded-4 w-100 d-flex flex-column"> <!-- Flex column for consistent height -->
                    <a href="jewe-detail.php?product_id=<?php echo $related['id']; ?>&category_id=<?php echo $category_id; ?>&category=jewelry" class="card shadow-sm border-light text-decoration-none">
                        <img src="./admin/<?php echo htmlspecialchars($related['product_image']); ?>" class="card-img-top"
                            alt="<?php echo htmlspecialchars($related['product_name']); ?>" style="height: 220px; object-fit: cover;">
                        <div class="card-body text-center d-flex flex-column justify-content-between">
                            <h5 class="card-title">$<?php echo htmlspecialchars($related['product_price']); ?></h5>
                        </div>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-muted">No related products found.</p>
    <?php endif; ?>
</div>

  </div>

  <?php include("./includes/review.php") ?>

  <!-- Swiper JS -->
  <script>
    var swiperMain = new Swiper(".mySwiper2", {
      spaceBetween: 10,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      }
    });
  </script>

  <?php include("./includes/footer.php") ?>
  <?php include("./includes/html-close.php") ?>