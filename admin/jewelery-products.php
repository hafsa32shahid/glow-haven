<?php
require("./inc/header.php");
require("./inc/bootstrap-inc.php");
?>

<body>
    <?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "glow&haven"; // Database name for jewelry products

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Get product details
        $category_id = $_POST['category_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];

        // Handle product image
        $product_image = $_FILES['product_image']['name'];
        $product_image_path = "jewelry-categories/{$category_id}/{$product_name}/{$product_image}";

        // Create product directory if it doesn't exist
        if (!file_exists(dirname($product_image_path))) {
            mkdir(dirname($product_image_path), 0777, true);
        }

        // Move uploaded product image
        move_uploaded_file($_FILES['product_image']['tmp_name'], $product_image_path);

        // Insert product into database
        $sql = "INSERT INTO jewelry_products (category_id, product_name, product_price, product_image) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isds", $category_id, $product_name, $product_price, $product_image_path);

        if ($stmt->execute()) {
            echo "
                <script>
                    Swal.fire({
                      title: 'Success!',
                      text: 'Jewelry product has been added successfully.',
                      icon: 'success',
                      confirmButtonText: 'OK',
                      timer: 3000, // Automatically close after 3 seconds
                      timerProgressBar: true
                    });
                </script>
            ";
        } else {
            echo "Error: " . $conn->error;
        }

    
    }

    // Fetch categories from the database
    $category_result = $conn->query("SELECT * FROM jewelery_categories");

    $conn->close();
    ?>

    <div class="fluid-container">
        <div class="row">
            <div class="col-3">
                <?php require("./inc/sidebar.php"); ?>
            </div>
            <div class="col-9">
                <div class="main">
                    <?php require("./inc/topbar.php") ?>
                    <div class="form-contain p-5">
                        <h2 class="logo-text" style="font-size:4rem;">Add Jewelry Products</h2>
                        <form method="POST" enctype="multipart/form-data">
                            <label for="category_id">Select Category:</label>
                            <select id="category_id" name="category_id" class="form-select" aria-label="Default select example" required>
                                <?php
                                // Check if categories were fetched and display them
                                if ($category_result && $category_result->num_rows > 0) {
                                    while ($row = $category_result->fetch_assoc()) {
                                        echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                    }
                                } else {
                                    echo "<option>No categories found</option>";
                                }
                                ?>
                            </select>

                            <label for="product_name" class="form-label">Product Name:</label>
                            <input type="text" id="product_name" name="product_name" class="form-control" required>

                            <label for="product_price" class="form-label">Product Price:</label>
                            <input type="number" id="product_price" name="product_price" class="form-control" step="0.01" required>

                            <label for="product_image" class="form-label">Product Image:</label>
                            <input type="file" id="product_image" name="product_image" class="form-control" accept="image/*" required>

                            <br><br>
                            <button type="submit" class="btn button rounded-5">Add Product</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require("./inc/footer.php"); ?>
</body>
