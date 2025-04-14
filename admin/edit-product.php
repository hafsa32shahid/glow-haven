<?php
include "../config/connection.php";

$type = $_GET['type']; // 'cosmetics' or 'jewelry'
$id = $_GET['id'];

// Fetch product data based on type
if ($type === 'cosmetics') {
    $query = "SELECT * FROM cosmet_products WHERE id = ?";
} else {
    $query = "SELECT * FROM jewelry_products WHERE id = ?";
}

// Prepare and execute the query
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];


    // Determine the table and prepare the update query
    if ($type === 'cosmetics') {
        $updateQuery = "UPDATE cosmet_products SET product_name = ?, product_price = ?,stock=? where id = $id";
    } else {
        $updateQuery = "UPDATE jewelry_products SET  product_name = ?, product_price = ?,stock=? where id = $id";
    }

    // Prepare and execute the update query
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param('sdi', $name, $price, $stock);
    $stmt->execute();

    // Redirect to the index page
    header("Location: view_products.php");
    exit();
}
?>
<?php include("./inc/header.php") ?>
<div class="fluid-container">
    <div class="row">
        <div class="col-3">
            <?php require("./inc/sidebar.php"); ?>
        </div>
        <div class="col-9">
            <div class="main">
                <?php include("./inc/topbar.php") ?>
                <div class="content_edit p-5">
                <h1>Edit Product (<?php echo ucfirst($type); ?>)</h1>
                <form method="POST">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($product['product_name']); ?>"
                        required><br>
                    <label for="price" class="form-label">Price:</label>
                    <input type="number"class="form-control"  name="price" value="<?php echo htmlspecialchars($product['product_price']); ?>"
                        required><br>
                    <label for="price" class="form-label">stock:</label>
                    <input type="number" class="form-control" name="stock" value="<?php echo htmlspecialchars($product['stock']); ?>">
                  
                    <button class="btn button mt-4" type="submit">Update</button>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
<?php include("./inc/footer.php") ?>