<?php
session_start();
include("./config/connection.php");
$order_id =  $_SESSION['order_id'];
// Fetch order details from the database
$order_query = "SELECT * FROM orders WHERE id = ?";
$order_stmt = $conn->prepare($order_query);
$order_stmt->bind_param("i", $order_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();

if ($order_result->num_rows === 0) {
    header("Location: error_page.php"); // Redirect if order not found
    exit();
}

$order = $order_result->fetch_assoc();

// Fetch order items from the database
$items_query = "SELECT * FROM order_items WHERE order_id = ?";
$items_stmt = $conn->prepare($items_query);
$items_stmt->bind_param("i", $order_id);
$items_stmt->execute();
$items_result = $items_stmt->get_result();
?>
 <?php include("./includes/header.php") ?>
    <style>
        body { background-color: #f9f9f9; font-family: Arial, sans-serif; }
        .progress-tracker { display: flex; justify-content: space-between; align-items: center; margin: 20px 0; }
        .progress-tracker div { text-align: center; font-size: 0.9rem; }
        .progress-circle { width: 30px; height: 30px; border-radius: 50%; background-color: #f75993; color: #fff; display: flex; align-items: center; justify-content: center; margin: 0 auto; }
        .progress-circle.bg-light { background-color: #f8f9fa; color: #000; }
        .progress-line { flex: 1; height: 2px; background-color: #ccc; margin: 0 10px; }
        .progress-line.active { background-color: #f75993; }
        .border-bottom { border-bottom: 1px solid #dee2e6 !important; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="text-center mb-4">
            <h2>Thank you for your order <span style="color:#f75993;">#<?php echo $order['id']; ?></span></h2>
            <p>We’ll send you an email with tracking information when your item ships.</p>
        </div>

        <!-- Progress Tracker -->
        <div class="progress-tracker">
            <div>
                <div class="progress-circle">&#10003;</div>
                <p>Order Placed</p>
            </div>
            <div class="progress-line active"></div>
            <div>
                <div class="progress-circle bg-light">2</div>
                <p>Processing</p>
            </div>
            <div class="progress-line"></div>
            <div>
                <div class="progress-circle bg-light">3</div>
                <p>Shipped</p>
            </div>
            <div class="progress-line"></div>
            <div>
                <div class="progress-circle bg-light">4</div>
                <p>Delivered</p>
            </div>
        </div>

        <!-- Order Details -->
        <div class="row mt-4">
            <div class="col-md-6">
                <h5>Order Details</h5>
                <ul class="list-unstyled">
                    <li><strong>Order #:</strong> <?php echo $order['id']; ?></li>
                    <li><strong>Order Status:</strong> <?php echo $order['o_status']; ?></li>
                    <li><strong>Order Date:</strong> <?php echo $order['order_date']; ?></li>
                </ul>
            </div>

            <div class="col-md-6">
                <h5>Shipping Address</h5>
                <p> lahore no 5 </p>
            </div>
        </div>

        <!-- Items Ordered -->
        <div class="mt-4">
            <h5>Items Ordered</h5>
            <?php while ($item = $items_result->fetch_assoc()): ?>
                <div class="d-flex justify-content-between border-bottom py-2">
                    <div class="d-flex">
                        <!-- <img src="https://via.placeholder.com/50" alt="Item" class="me-3"> -->
                        <div>
                            <p class="mb-0"><?php echo $item['product_name']; ?></p>
                            <small>Quantity: <?php echo $item['quantity']; ?></small>
                        </div>
                    </div>
                    <p class="mb-0 text-end">$<?php echo number_format($item['price'], 2); ?></p>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Order Summary -->
        <div class="row mt-4">
            <div class="col-md-4">
                <!-- <h5>Order Summary</h5> -->
                <!-- <ul class="list-unstyled">
                    <li><strong>Subtotal:</strong> $<?php echo number_format($order['order_total'], 2); ?></li>
                    <li><strong>Shipping:</strong> $0.00</li>
                    <li><strong>Tax:</strong> $0.00</li>
                </ul> -->
                <h5 class="mt-2">Total: <span style="color:#f75993;">Rs<?php echo number_format($order['total_price'], 2); ?></span></h5>

            </div>

            <div class="col-md-4">
              <h5>Billing Address</h5>
                <p><?php echo nl2br($order['address']); ?></p>
            </div>
            <div class="col-md-4">
             <a class="btn button" href="index.php">Back Home</a>
            </div>


        </div>
    </div>

    <?php include("./includes/html-close.php") ?>
