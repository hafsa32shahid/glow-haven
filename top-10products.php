<?php require("./includes/header.php"); ?>
<?php
session_start();
require("./includes/navbar.php");
include("./config/connection.php");

// Fetch top 10 best-selling products from both tables
$query = "
    SELECT 
        id, 
        product_name, 
        product_image, 
        product_price, 
        product_type, 
        category_id, 
        COALESCE(avg_rating, 0) AS rating, 
        COALESCE(total_reviews, 0) AS reviews_count, 
        total_sold
    FROM (
        -- Fetch top-selling products from cosmet_products
        SELECT 
            c.id, 
            c.product_name, 
            c.product_image, 
            c.product_price, 
            'cosmetics' AS product_type, 
            NULL AS category_id,  -- No category_id for cosmetics
            SUM(oi.quantity) AS total_sold,
            AVG(pr.rating) AS avg_rating, 
            COUNT(pr.id) AS total_reviews
        FROM 
            cosmet_products c
        JOIN 
            order_items oi ON c.id = oi.product_id
        LEFT JOIN 
            product_reviews pr ON c.id = pr.product_id
        GROUP BY 
            c.id

        UNION ALL

        -- Fetch top-selling products from jewelry_products
        SELECT 
            j.id, 
            j.product_name, 
            j.product_image, 
            j.product_price, 
            'jewelry' AS product_type, 
            j.category_id,  -- Ensure category_id is included
            SUM(oi.quantity) AS total_sold,
            AVG(pr.rating) AS avg_rating, 
            COUNT(pr.id) AS total_reviews
        FROM 
            jewelry_products j
        JOIN 
            order_items oi ON j.id = oi.product_id
        LEFT JOIN 
            product_reviews pr ON j.id = pr.product_id
        GROUP BY 
            j.id, j.category_id  -- Group by category_id as well
    ) AS combined_products
    ORDER BY 
        total_sold DESC
    LIMIT 10;
";


$result = $conn->query($query);
?>

<div class="container-fluid p-4">
    <div class="row flex-md-row flex-sm-column-reverse">
        <?php require("./includes/sidebar.php"); ?>

        <!-- Best Selling Products Section -->
        <div class="col-md-9">
            <h2 class="mb-4">Top 10 Best Selling Products</h2>
            <div class="row">
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
        </div>

    </div>
</div>

<?php require("./includes/review.php"); ?>
<?php require("./includes/footer.php"); ?>
<?php require("./includes/html-close.php"); ?>