
<?php
require("../middleware/auth-admin.php");
require("./inc/header.php") ?>

</head>

<body>
    <div class="container1">
        <?php require("./inc/sidebar.php") ?>

        <!-- ========================= Main ==================== -->
        <div class="main">
           <?php include("./inc/topbar.php"); ?>

            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Top 10 Best Selling Products</h2>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>Product Name</td>
                                <td>Total Quantity Sold</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            // Database connection
                            $host = 'localhost';
                            $dbname = 'glow&haven';
                            $username = 'root';
                            $password = '';

                            $conn = new mysqli($host, $username, $password, $dbname);

                            // Check connection
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            // Query to fetch top 10 best-selling products
                            $query = "
                SELECT 
                    oi.product_name, 
                    SUM(oi.quantity) AS total_quantity_sold
                FROM 
                    order_items oi
                JOIN 
                    orders o ON oi.order_id = o.id
                GROUP BY 
                    oi.product_name
                ORDER BY 
                    total_quantity_sold DESC
                LIMIT 10
            ";

                            $result = $conn->query($query);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                        <td>{$row['product_name']}</td>
                        <td>{$row['total_quantity_sold']}</td>
                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='2'>No records found</td></tr>";
                            }

                            // Close connection
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>


                <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>Top 10 Customers</h2>
                    </div>

                    <table>
                    <?php
include("../config/connection.php");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch top 10 users with the highest total purchase amount
$query = "
    SELECT 
        u.id, 
        u.fullname,  
        SUM(o.total_price) AS total_spent
    FROM 
        users u
    JOIN 
        orders o ON u.id = o.user_id
    GROUP BY 
        u.id, u.fullname
    ORDER BY 
        total_spent DESC
    LIMIT 10
";
$result = $conn->query($query);
?>

<div class="container mt-4">
    
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
    ?>
            <div class="card mb-3 shadow-sm border-0"> <!-- Each user in a separate card -->
                <div class="card-body text-center d-flex">
                    <img src="assets/imgs/customer01.jpg" alt="User Image" class="img-fluid rounded-circle user-img">
                    <h5 class="mt-3"><?= htmlspecialchars($row['fullname']) ?></h5>
                </div>
            </div>
    <?php
        }
    } else {
        echo "<p class='text-center'>No customer data available</p>";
    }

    // Close connection
    $conn->close();
    ?>
</div>

<style>
    .user-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border: 3px solid #ddd;
    }
    .card {
        border-radius: 10px;
        transition: transform 0.3s;
    }
    .card:hover {
        transform: scale(1.02);
    }
</style>

                    </table>
                </div>

            </div>
        </div>
    </div>

    <?php require("./inc/footer.php") ?>