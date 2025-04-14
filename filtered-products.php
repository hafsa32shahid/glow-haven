<?php
require("./includes/header.php");
session_start();
require("./includes/navbar.php");
?>

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

                    $categories = $_POST['categories'] ?? [];
                    $priceRange = $_POST['priceRange'] ?? 10000;
                    $rating = $_POST['rating'] ?? 0;

                    $minPrice = 0;
                    $maxPrice = $priceRange;
                    $query = "SELECT * FROM (
                        SELECT p.id, p.product_name, NULL AS category_id, p.product_image, p.product_price, c.subcategory_name AS category_name , 'cosmetics' AS product_type, 
                               (SELECT AVG(r.rating) FROM product_reviews r WHERE r.product_id = p.id) AS rating
                        FROM cosmet_products p
                        JOIN cosm_subcategories c ON p.subcategory_id = c.id
                        
                        UNION ALL
                        
                        SELECT j.id, j.product_name, j.category_id, j.product_image, j.product_price, jc.name AS category_name, 'jewelry' AS product_type, 
                               (SELECT AVG(r.rating) FROM product_reviews r WHERE r.product_id = j.id) AS rating
                        FROM jewelry_products j
                        JOIN jewelery_categories jc ON j.category_id = jc.id
                      ) AS products 
                      WHERE 1=1";


                    // Apply filters
                    if (!empty($categories)) {
                        $categoriesList = "'" . implode("','", $categories) . "'";
                        $query .= " AND category_name IN ($categoriesList)";
                    }

                    if ($minPrice >= 0 && $maxPrice > 0) {
                        $query .= " AND product_price BETWEEN $minPrice AND $maxPrice";
                    }

                    if ($rating > 0) {
                        $query .= " AND rating >= $rating";
                    }

                    $query .= " GROUP BY product_name"; // Ensure unique products by name
                    
                    $result = $conn->query($query);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Determine detail page based on product type
                            if ($row['product_type'] === 'cosmetics') {
                                $detail_page = 'product-detail.php?product_id=' . htmlspecialchars($row['id']);
                            } else {
                                $category_id = htmlspecialchars($row['category_id']);
                                $detail_page = 'jewe-detail.php?product_id=' . htmlspecialchars($row['id']) . '&category_id=' . htmlspecialchars($row['category_id']);
                            }


                            echo "<div class='col-md-4 mb-4'>
            <a href='$detail_page' class='card shadow-sm border-light text-decoration-none'>
                <img src='./admin/" . htmlspecialchars($row['product_image']) . "' class='card-img-top' alt='" . htmlspecialchars($row['product_name']) . "' style='height: 220px; object-fit: cover;'>
                <div class='card-body text-center'>
                    <h5 class='card-title'>Rs" . htmlspecialchars($row['product_price']) . "</h5>
                </div>
            </a>
          </div>";
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