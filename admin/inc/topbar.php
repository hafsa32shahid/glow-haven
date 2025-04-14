<div class="topbar">
    <div class="toggle">
        <ion-icon name="menu-outline"></ion-icon>
    </div>

    <div class="user">
        <img src="https://img.freepik.com/free-photo/happy-successful-muslim-businesswoman-posing-outside_74855-2007.jpg?ga=GA1.1.24328383.1694452068&semt=ais_hybrid"
            alt="">
    </div>
</div>

<!-- ======================= Cards ================== -->
<?php
$conn = new mysqli("localhost", "root", "", "glow&haven");
$query = "
                      SELECT 
                      (SELECT COUNT(*) FROM orders) AS total_orders,
                      (SELECT COUNT(*) FROM orders WHERE o_status = 'Delivered') AS total_sales,
                      (SELECT COUNT(*) FROM contacts) AS total_comments,
                      (SELECT IFNULL(SUM(total_price), 0) FROM orders WHERE o_status = 'Delivered') AS total_earnings
             ";

$result2 = $conn->query($query);
$data = $result2->fetch_assoc();

// Assign values with fallback to 0
$totalOrders = $data['total_orders'] ?? 0;
$totalSales = $data['total_sales'] ?? 0;
$totalComments = $data['total_comments'] ?? 0;
$totalEarnings = $data['total_earnings'] ?? 0;
?>
<div class="cardBox">
    <div class="card1">
        <div>
            <div class="numbers"><?php echo $totalOrders; ?></div>
            <div class="cardName">Orders</div>
        </div>
        <div class="iconBx">
            <i class="fa-solid fa-bag-shopping"></i>
        </div>
    </div>

    <div class="card1">
        <div>
            <div class="numbers"><?php echo $totalSales; ?></div>
            <div class="cardName">Sales</div>
        </div>
        <div class="iconBx">
            <ion-icon name="cart-outline"></ion-icon>
        </div>
    </div>

    <div class="card1">
        <div>
            <div class="numbers"><?php echo $totalComments; ?></div>
            <div class="cardName">Comments</div>
        </div>
        <div class="iconBx">
            <ion-icon name="chatbubbles-outline"></ion-icon>
        </div>
    </div>

    <div class="card1">
        <div>
            <div class="numbers">Rs: <?php echo number_format($totalEarnings, 2); ?></div>
            <div class="cardName">Earnings</div>
        </div>
        <div class="iconBx">
            <ion-icon name="cash-outline"></ion-icon>
        </div>
    </div>
</div>