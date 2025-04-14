<?php
include("./config/connection.php"); // Include your database connection file

// Get the search term from the AJAX request
$search_value = isset($_POST['search']) ? $_POST['search'] : '';

// Initialize arrays for results from each table
$cosmetResults = [];
$jewelryResults = [];

// Process the search query if it's not empty
if (!empty($search_value)) {
  // Add wildcards to the search term for partial matching
  $search_term = "%$search_value%";

  // Query for cosmetics products
  $sqlCosmet = "
    SELECT id, product_name, product_price, product_image 
    FROM cosmet_products 
    WHERE product_name LIKE ? 
    LIMIT 10
  ";
  $stmtCosmet = $conn->prepare($sqlCosmet);
  $stmtCosmet->bind_param("s", $search_term);
  $stmtCosmet->execute();
  $resultCosmet = $stmtCosmet->get_result();

  // Store results in the cosmetics array
  while ($row = $resultCosmet->fetch_assoc()) {
    $cosmetResults[] = $row;
  }

  // Query for jewelry products
  $sqlJewelry = "
    SELECT id, product_name, product_price, product_image ,category_id
    FROM jewelry_products 
    WHERE product_name LIKE ? 
    LIMIT 10
  ";
  $stmtJewelry = $conn->prepare($sqlJewelry);
  $stmtJewelry->bind_param("s", $search_term);
  $stmtJewelry->execute();
  $resultJewelry = $stmtJewelry->get_result();

  // Store results in the jewelry array
  while ($row = $resultJewelry->fetch_assoc()) {
    $jewelryResults[] = $row;
  }

  // Close statements
  $stmtCosmet->close();
  $stmtJewelry->close();
}

// Return the results as HTML
if (!empty($cosmetResults) || !empty($jewelryResults)) {
  // Display cosmetics products
  if (!empty($cosmetResults)) {
    echo '<h3 class="text-dark">Cosmetics Products</h3>';
    foreach ($cosmetResults as $product) {
      echo '
        <a href="./product-detail.php?product_id=' . $product['id'] . '&category=cosmetics" class="text-decoration-none">
          <div class="card mb-3">
            <div class="row g-0">
              <div class="col-md-3">
                <img src="./admin/' . $product['product_image'] . '" class="img-fluid rounded-start" alt="' . $product['product_name'] . '" />
              </div>
              <div class="col-md-9">
                <div class="card-body">
                  <h5 class="card-title text-dark">' . $product['product_name'] . '</h5>
                  <p class="card-text text-dark"><strong>Price:</strong> $' . $product['product_price'] . '</p>
                </div>
              </div>
            </div>
          </div>
        </a>
      ';
    }
  }

  // Display jewelry products
  if (!empty($jewelryResults)) {
    echo '<h3 class="text-dark">Jewelry Products</h3>';
    foreach ($jewelryResults as $product) {
      echo '
        <a href="./jewe-detail.php?product_id=' . $product['id'] . '&category_id=' . $product['category_id'] . '&category=jewelry"
 class="text-decoration-none">
          <div class="card mb-3">
            <div class="row g-0">
              <div class="col-md-3">
                <img src="./admin/' . $product['product_image'] . '" class="img-fluid rounded-start" alt="' . $product['product_name'] . '" />
              </div>
              <div class="col-md-9">
                <div class="card-body">
                  <h5 class="card-title text-dark">' . $product['product_name'] . '</h5>
                  <p class="card-text text-dark"><strong>Price:</strong> $' . $product['product_price'] . '</p>
                </div>
              </div>
            </div>
          </div>
        </a>
      ';
    }
  }
} else {
  echo '<p class="text-muted">No results found.</p>';
}
?>
