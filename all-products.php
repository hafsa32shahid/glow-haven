
<?php require("./includes/header.php") ?>
<?php session_start() ?>
<?php require("./includes/navbar.php") ?>

<div class="container-fluid p-4">
  <div class="row">
    <?php require("./includes/sidebar.php") ?>

    <!-- Main Content -->
    <div class="col-lg-9 col-md-8">
      <div class="p-3">
        <h4 class="mb-4">All Products</h4>
        <div class="row">
    <?php
    require("./config/connection.php");

    // Unified Query for Cosmetics & Jewelry with category_id
    $product_query = "
        SELECT id, product_name, product_image, product_price, NULL AS category_id, 'cosmetics' AS product_type FROM cosmet_products
        UNION ALL
        SELECT id, product_name, product_image, product_price, category_id, 'jewelry' AS product_type FROM jewelry_products
    ";

    $result = $conn->query($product_query);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Determine detail page based on product type
            if ($row['product_type'] === 'cosmetics') {
                $detail_page = 'product-detail.php?product_id=' . htmlspecialchars($row['id']);
            } else {
                $category_id = htmlspecialchars($row['category_id']);
                $detail_page = 'jewe-detail.php?product_id=' . htmlspecialchars($row['id']) . '&category_id=' . $category_id;
            }
            ?>
            <!-- Product Card -->
            <div class="col-md-4 mb-4">
                <a href="<?php echo $detail_page; ?>" class="card shadow-sm border-light text-decoration-none">
                    <img src="./admin/<?php echo htmlspecialchars($row['product_image']); ?>" class="card-img-top"
                        alt="<?php echo htmlspecialchars($row['product_name']); ?>" style="height: 220px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title">$<?php echo htmlspecialchars($row['product_price']); ?></h5>
                    </div>
                </a>
            </div>
            <?php
        }
    } else {
        echo "<p class='text-center'>No products found.</p>";
    }

    $conn->close();
    ?>
</div>



      </div>
    </div>
  </div>
</div>

<?php require("./includes/review.php") ?>
<?php require("./includes/footer.php") ?>
<?php require("./includes/html-close.php") ?>