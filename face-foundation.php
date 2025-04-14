<?php session_start(); ?>
<?php require("./includes/header.php"); ?>
<?php require("./includes/navbar.php"); ?>

<div class="container-fluid p-4">
<div class="row flex-md-row flex-sm-column-reverse">
    <?php require("./includes/sidebar.php"); ?>

    <!-- Main Content -->
    <div class="col-lg-9 col-md-8">
      <div class="p-3">
        <!-- Dynamic Product Grid -->
        <h4>Products</h4>
        <div class="row">
          <?php
          include("./config/connection.php");

          // Check connection
          if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
          }

          // Check if subcategory_id is provided
          if (isset($_GET['subcategory_id'])) {
              $subcategory_id = intval($_GET['subcategory_id']); // Sanitize input
          } else {
              die("<p class='text-danger'>Subcategory ID not provided.</p>");
          }

          // Fetch products from the database for the given subcategory
          $sql = "SELECT p.id, p.product_name, p.product_price, p.product_image, s.subcategory_name 
                  FROM cosmet_products p 
                  INNER JOIN cosm_subcategories s ON p.subcategory_id = s.id 
                  WHERE p.subcategory_id = ?";

          $stmt = $conn->prepare($sql);
          $stmt->bind_param("i", $subcategory_id);
          $stmt->execute();
          $result = $stmt->get_result();

        
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  // Display product grid item
                  echo "<div class='col-sm-6 col-lg-4 mb-4'>";
                  echo "<a href='product-detail.php?product_id={$row['id']}&category=cosmetics' class='card shadow-sm border-light text-decoration-none'>";
                  echo "<img src='./admin/{$row['product_image']}' class='card-img-top' alt='{$row['product_name']}'>";
                  echo "<div class='card-body text-center'>";
                  echo "<h5 class='card-title'>Rs" . number_format($row['product_price'], 2) . "</h5>";
                  echo "</div>";
                  echo "</a>";
                  
                  echo "</div>";
              }
          } else {
              echo "<p class='text-warning'>No products found for this subcategory.</p>";
          }

          $stmt->close();
          $conn->close();
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require("./includes/review.php"); ?>
<?php require("./includes/footer.php"); ?>
<?php require("./includes/html-close.php"); ?>
