<?php
require("./inc/header.php");
require("./inc/bootstrap-inc.php");
?>


    
<script>
    // JavaScript to redirect to the Add Shades page after product is added
        function redirectToAddShades(productName, subcategoryId) {
    window.location.href = `shade-form.php?product_name=${productName}&subcategory_id=${subcategoryId}`;
    }

</script>

<body>
    <?php
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "glow&haven";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Get product details
        $subcategory_id = intval($_POST['subcategory_id']);
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $has_shades = $_POST['has_shades'];
        $stock = $_POST['stock'];

        // Handle product image
        $product_image = $_FILES['product_image']['name'];
        $product_image_path = "cosm-categories/{$subcategory_id}/{$product_name}/{$product_image}";

        // Create product directory if it doesn't exist
        if (!file_exists(dirname($product_image_path))) {
            mkdir(dirname($product_image_path), 0777, true);
        }

        // Move uploaded product image
        move_uploaded_file($_FILES['product_image']['tmp_name'], $product_image_path);

        // Insert product into database
        $sql = "INSERT INTO cosmet_products (subcategory_id, product_name, product_price, has_shades, product_image, stock) 
        VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isdssi", $subcategory_id, $product_name, $product_price, $has_shades, $product_image_path, $stock);

        if ($stmt->execute()) {
            $product_id = $stmt->insert_id; // Get inserted product ID

            echo "
            <script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Product has been added successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    timer: 3000,
                    timerProgressBar: true,
                }).then(() => {
                    redirectToAddShades('{$product_name}', {$subcategory_id});
                });
            </script>
        ";
        
        } else {
            echo "Error: " . $conn->error;
        }

        $stmt->close();
    }

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
                        <h2 class="logo-text" style="font-size:4rem;">Add The Cosmetics Products</h2>
                        <form method="POST" enctype="multipart/form-data">
                            <label for="subcategory_id">Select Subcategory:</label>
                            <select id="subcategory_id" name="subcategory_id" class="form-select"
                                aria-label="Default select example" required>
                                <?php
                                // Database connection
                                $conn = new mysqli($servername, $username, $password, $dbname);
                                $result = $conn->query("SELECT * FROM cosm_subcategories");

                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['id']}'>{$row['subcategory_name']}</option>";
                                }

                                $conn->close();
                                ?>
                            </select>

                            <label for="product_name" class="form-label">Product Name:</label>
                            <input type="text" id="product_name" name="product_name" class=" form-control" required>

                            <label for="product_price" class="form-label">Product Price:</label>
                            <input type="number" id="product_price" name="product_price" class=" form-control"
                                step="0.01" required>

                            <label for="product_image" class="form-label">Product Image:</label>
                            <input type="file" id="product_image" name="product_image" class=" form-control"
                                accept="image/*" required>
                            <label for="product_image" class="form-label">How Much Products:</label>
                            <input type="numbers"  name="stock" class=" form-control"
                                accept="image/*" required>
                            <label for="has_shades" class="form-label">Does this product have shades?</label>
                            <select id="has-shade" name="has_shades" class="form-select" aria-label="Default select example">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>

                            <br><br>

                            <button type="submit" class="btn button rounded-5">Add Product</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require("./inc/footer.php"); ?>

