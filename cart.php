<?php include("./includes/header.php") ?>
<?php session_start(); ?>
<?php
include("./config/connection.php");
$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
// Fetch cart items from the database
$cart_item = "SELECT * FROM cart where user_id = '" . $user_id . "'";
$cart_stmt = $conn->prepare($cart_item);
$cart_stmt->execute();
$cart_data = $cart_stmt->get_result();
?>
<!-- remove cart item -->
<?php
if (isset($_POST['remove'])) {
    // $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
    $cart_id = $_POST['cart_id'];
    $remove_query = "DELETE FROM cart WHERE id = ? AND user_id = ?";
    $remove_stmt = $conn->prepare($remove_query);
    $remove_stmt->bind_param("ii", $cart_id, $user_id);
    $remove_item = $remove_stmt->execute();
    if ($remove_item) {
        echo '
        <script>
            Swal.fire({
                title: "Success!",
                text: "Product removed successfully from the cart.",
                icon: "success",
                confirmButtonText: "OK"
            }).then(() => {
                window.location.href = "cart.php";
            });
        </script>';
    } else {
        echo '
        <script>
            Swal.fire({
                title: "Error!",
                text: "Error removing product from the cart.",
                icon: "error",
                confirmButtonText: "OK"
            });
        </script>';
    }

    $remove_stmt->close();
}


?>
<!-- update cart -->
<?php
if (isset($_POST['update'])) {
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];

    if ($quantity < 1) {
        echo '
        <script>
            Swal.fire({
                title: "Error!",
                text: "Quantity must be at least 1.",
                icon: "error",
                confirmButtonText: "OK"
            });
        </script>';
        exit();
    }

    $update_query = "UPDATE cart SET quantity = ? WHERE id = ? AND user_id = ?";
    $update_stmt = $conn->prepare($update_query);

    if ($update_stmt) {
        $update_stmt->bind_param("iii", $quantity, $cart_id, $user_id);

        if ($update_stmt->execute()) {
            echo '
            <script>
                Swal.fire({
                    title: "Success!",
                    text: "Product quantity updated successfully in the cart.",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    window.location.href = "cart.php";
                });
            </script>';
        } else {
            echo '
            <script>
                Swal.fire({
                    title: "Error!",
                    text: "Error updating product in the cart.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            </script>';
        }

        $update_stmt->close();
    } else {
        echo '
        <script>
            Swal.fire({
                title: "Error!",
                text: "Failed to prepare the update statement.",
                icon: "error",
                confirmButtonText: "OK"
            });
        </script>';
    }
}

?>
<!-- Grand Total -->
<?php

$query = "SELECT SUM(product_price * quantity) AS grand_total FROM cart WHERE user_id = '$user_id'";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $grand_total = $row['grand_total'];
} else {
    $grand_total = 0; // Set to 0 if there are no items in the cart
}
?>


<?php include("./includes/navbar.php") ?>

<div class="fluid-container">
    <div class="row">
        <div class="col-lg-9 col-md-12 p-5">
            <table class="table w-100">
                <thead>
                    <tr>

                        <th>Product</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Shade</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Remove</th>
                        <th>Update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if there are items in the cart
                    if ($cart_data->num_rows > 0) {
                        while ($result = $cart_data->fetch_assoc()) {
                            // Display each cart item
                            ?>
                            <tr>

                                <td><img src="./admin/<?php echo $result['product_image']; ?>" alt="Product Image" width="50">
                                </td>
                                <td><?php echo htmlspecialchars($result['product_name']); ?></td>
                                <td><?php echo "Rs " . number_format($result['product_price'], 2); ?></td>
                                <td><?php echo !empty($result['product_shade']) ? htmlspecialchars($result['product_shade']) : "No Shade"; ?>
                                </td>
                                <!-- Remove button -->
                                <form action="cart.php" method="POST">
                                    <td><input class="w-50 form-control" type="number" name="quantity"
                                            value="<?php echo $result['quantity']; ?>">
                                    </td>
                                    <td><?php echo "Rs " . number_format($result['product_price'] * $result['quantity'], 2); ?>
                                    </td>

                                    <td>

                                        <input type="hidden" name="cart_id" value="<?php echo $result['id']; ?>">
                                        <button type="submit" name="update" class="btn btn-success">Update</button>
                                </form>
                                </td>
                                <td>
                                    <!-- Remove button -->
                                    <form action="cart.php" method="POST">
                                        <input type="hidden" name="cart_id" value="<?php echo $result['id']; ?>">
                                        <button type="submit" name="remove" class="btn btn-danger">Remove</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='5'>Your cart is empty!</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-lg-2 col-md-12">
            <h4>Total: <?php echo "Rs " . number_format($grand_total, 2); ?></h4>
            <!-- Proceed to Checkout Button -->
            <a href="javascript:void(0);" class="btn btn-success" id="checkoutBtn">Proceed to Checkout</a>
        </div>
    </div>
</div>
<script>
    document.getElementById("checkoutBtn").addEventListener("click", function() {
        // Get cart count from PHP (number of items in the cart)
        let cartCount = <?php echo $cart_data->num_rows; ?>; 
        
        if (cartCount > 0) {
            window.location.href = "checkout.php"; // Redirect if items exist
        } else {
            Swal.fire({
                title: "Cart Empty!",
                text: "Please add items to your cart before proceeding.",
                icon: "warning",
                confirmButtonText: "OK"
            });
        }
    });
</script>
<?php include("./includes/html-close.php") ?>