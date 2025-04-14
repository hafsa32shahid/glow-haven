<?php include("./includes/header.php") ?>
<?php
include("./config/connection.php");
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['o_place'])) {
    // Get form data
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $work_phone = $_POST['work_phone'];
    $cell_no = $_POST['cell_no'];
    $dob = $_POST['dob'];
    $category = $_POST['category'];
    $user_id = $_SESSION['id'];

    // ✅ Step 1: Calculate total price from cart
    $cart_query = "SELECT product_id, product_name, product_type, product_price, quantity FROM cart WHERE user_id = ?";
    $cart_stmt = $conn->prepare($cart_query);
    $cart_stmt->bind_param("i", $user_id);
    $cart_stmt->execute();
    $cart_result = $cart_stmt->get_result();

    $total_price = 0;

    // Calculate total price
    while ($cart_item = $cart_result->fetch_assoc()) {
        $total_price += $cart_item['product_price'] * $cart_item['quantity'];
    }

    // ✅ Step 2: Insert into orders table with total_price
    $order_query = "INSERT INTO orders (user_id, name, address, email, work_phone, cell_no, dob, category, total_price) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $order_stmt = $conn->prepare($order_query);
    $order_stmt->bind_param("isssssssd", $user_id, $name, $address, $email, $work_phone, $cell_no, $dob, $category, $total_price);

    if ($order_stmt->execute()) {
        // ✅ Step 3: Get last inserted order_id
        $order_id = $conn->insert_id;

        // ✅ Step 4: Insert cart items into order_items
        $cart_stmt->execute();
        $cart_result = $cart_stmt->get_result();
        $order_items_query = "INSERT INTO order_items (order_id, product_id, product_type, product_name, quantity,price) 
                              VALUES (?, ?, ?, ?, ?, ?)";
        $order_items_stmt = $conn->prepare($order_items_query);

        while ($cart_item = $cart_result->fetch_assoc()) {
            $order_items_stmt->bind_param(
                "iissid",
                $order_id,
                $cart_item['product_id'],
                $cart_item['product_type'],
                $cart_item['product_name'],
                $cart_item['quantity'],
                $cart_item['product_price']
            );

            if (!$order_items_stmt->execute()) {
                die("Error inserting order item: " . $order_items_stmt->error);
            }
        }

        // ✅ Step 5: Clear the cart
        $clear_cart_query = "DELETE FROM cart WHERE user_id = ?";
        $clear_cart_stmt = $conn->prepare($clear_cart_query);
        $clear_cart_stmt->bind_param("i", $user_id);
        $clear_cart_stmt->execute();

        // ✅ Store order_id in session
        $_SESSION['order_id'] = $order_id;

        // ✅ Step 6: Update stock quantities based on order items
        $cart_result->data_seek(0); // Reset the pointer to the beginning

        while ($cart_item = $cart_result->fetch_assoc()) {
            $product_id = $cart_item['product_id'];
            $product_type = $cart_item['product_type'];
            $quantity_sold = $cart_item['quantity'];

            // Determine which table to update
            $table_name = ($product_type === 'cosmetics') ? 'cosmet_products' : 'jewelry_products';

            // Update the stock
            $update_stock_query = "UPDATE $table_name 
                           SET stock = GREATEST(stock - ?, 0) 
                           WHERE id = ?";
            $update_stock_stmt = $conn->prepare($update_stock_query);
            $update_stock_stmt->bind_param("ii", $quantity_sold, $product_id);
            $update_stock_stmt->execute();
            $update_stock_stmt->close();
        }


        // ✅ Redirect to the order placed page with order_id

        echo "<script>
    Swal.fire({
        icon: 'success',
        title: 'Order Placed!',
        text: 'Your order has been placed successfully.',
        showConfirmButton: false,
        timer: 1000
    }).then(() => {
        window.location.href = 'order-placed.php?order_id=$order_id';
    });
</script>";
        exit;

    } else {
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Order Failed!',
            text: 'Error placing order. Please try again.',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'checkout.php';
        });
    </script>";
    }

    // Close statements
    $order_stmt->close();
    $cart_stmt->close();
    $order_items_stmt->close();
    $clear_cart_stmt->close();
    $conn->close();
}
?>



<div class="container my-5">
    <h1 class="text-center mb-4 logo-text" style="font-size:4rem;">Checkout</h1>

    <!-- Checkout Form -->
    <form method="POST" id="checkoutForm">
        <div class="row">
            <!-- Personal Information -->
            <div class="col-md-6">
                <h3>Personal Information</h3>
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control rounded-4" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control rounded-4" id="address" name="address" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control rounded-4" id="email" name="email" required>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="col-md-6">
                <h3>Contact Information</h3>
                <div class="mb-3">
                    <label for="work_phone" class="form-label">Work Phone No.</label>
                    <input type="tel" class="form-control rounded-4" id="work_phone" name="work_phone" required>
                </div>
                <div class="mb-3">
                    <label for="cell_no" class="form-label">Cell No.</label>
                    <input type="tel" class="form-control rounded-4" id="cell_no" name="cell_no" required>
                </div>
                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control rounded-4" id="dob" name="dob" required>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select class="form-select rounded-4" id="category" name="category" required>
                        <option value="Individual">Individual</option>
                        <option value="Business">Business</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="d-flex align-content-center justify-content-center text-center mt-4">
            <a href="cart.php" class="btn button btn-dark">Back</a>
            <button type="submit" name="o_place" class="btn secbtn ms-4" id="placeOrderBtn">Order Place</button>
        </div>
    </form>
</div>

<?php include("./includes/html-close.php") ?>