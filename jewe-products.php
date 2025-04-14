
<?php require("./includes/header.php"); ?>
<?php
session_start(); 
require("./includes/navbar.php");


if (isset($_GET['category_id'])) {
    $category_id = intval($_GET['category_id']); // Sanitize input
} else {
    die("<p class='text-danger'>Category ID not provided.</p>");
}
?>



<div class="container-fluid p-4">
    <div class="row flex-md-row flex-sm-column-reverse">
        <?php require("./includes/sidebar.php"); ?>

        <!-- Main Content -->
        <div class="col-lg-9 col-md-8">
            <div class="p-3">
                <!-- Dynamic Product Grid -->
                <h4>Jewelry Products</h4>
                <div class="row">
                    <?php
                    include("./config/connection.php");

                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Check if category_id is provided
                    if (isset($_GET['category_id'])) {
                        $category_id = intval($_GET['category_id']); // Sanitize input
                    } else {
                        die("<p class='text-danger'>Category ID not provided.</p>");
                    }

                    // Fetch jewelry products from the database for the given category
                    $sql = "SELECT p.id, p.product_name, p.product_price, p.product_image, c.name as category_name 
                            FROM jewelry_products p 
                            INNER JOIN jewelery_categories c ON p.category_id = c.id 
                            WHERE p.category_id = ?";

                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $category_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Display jewelry product grid item
                            echo "<div class='col-sm-6 col-lg-4 mb-4'>";
                            echo "<a href='jewe-detail.php?product_id={$row['id']}&category_id={$category_id}&category=jewelry' class='card shadow-sm border-light text-decoration-none'>";
                            echo "<img src='./admin/{$row['product_image']}' class='card-img-top' alt='{$row['product_name']}'>";
                            echo "<div class='card-body text-center'>";
                            // echo "<h5 class='card-title'>{$row['product_name']}</h5>";
                            echo "<p class='card-text'>Rs: " . number_format($row['product_price'], 2) . "</p>";
                            echo "</div>";
                            echo "</a>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p class='text-warning'>No jewelry products found for this category.</p>";
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
