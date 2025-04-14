<?php include("./inc/header.php") ?>
<?php
include("../config/connection.php");

// Fetch orders with product details
$sql = "SELECT 
    o.id AS order_id, 
    o.user_id, 
    o.name, 
    o.address, 
    o.email, 
    o.work_phone, 
    o.cell_no, 
    o.dob, 
    o.category, 
    o.order_date, 
    o.o_status, 
    o.total_price, 
    oi.product_id, 
    oi.product_type, 
    oi.quantity, 
    oi.price, 
    oi.product_name, 
    p.product_image 
FROM orders o
JOIN order_items oi ON o.id = oi.order_id
JOIN (
    SELECT id AS product_id, product_name, product_image FROM cosmet_products
    UNION ALL
    SELECT id AS product_id, product_name, product_image FROM jewelry_products
) AS p ON oi.product_id = p.product_id;
";

$result = $conn->query($sql);
?>

<div class="fluid-container">
    <div class="row">
        <div class="col-3">
            <?php require("./inc/sidebar.php"); ?>
        </div>
        <div class="col-9">
            <div class="main">
                <?php include("./inc/topbar.php"); ?>
                <div class="detail">
                    <div class="recentOrders p-5">
                        <h2>Orders</h2>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Product</th>
                                    <!-- <th>Image</th> -->
                                    <th>Quantity</th>
                                    <!-- <th>Price</th> -->
                                    <th>Total Price</th>
                                    <th>Order Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                                        <td><?php echo htmlspecialchars($row['cell_no']); ?></td>
                                        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                                        <!-- <td>
                                            <img src="./<?php echo htmlspecialchars($row['product_image']); ?>" width="50"
                                                height="50" alt="Product Image">
                                        </td> -->
                                        <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                                        <!-- <td>$<?php echo htmlspecialchars($row['price']); ?></td> -->
                                        <td>Rs: <?php echo htmlspecialchars($row['total_price']); ?></td>
                                        <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                                        <?php
                                        // Display current status with a form to update it
                                        $statusOptions = ['Order Placed', 'Processing', 'Shipped', 'Delivered'];
                                        ?>
                                        <td>
                                            <form action="./func/update_status.php" method="POST"
                                                class="d-flex align-items-center">
                                                <input type="hidden" name="order_id"
                                                    value="<?php echo $row['order_id']; ?>">
                                                <select name="new_status" class="form-select me-2">
                                                    <?php foreach ($statusOptions as $status): ?>
                                                        <option value="<?php echo $status; ?>" <?php echo ($row['o_status'] === $status) ? 'selected' : ''; ?>>
                                                            <?php echo $status; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </form>
                                        </td>

                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include("./inc/footer.php"); ?>
