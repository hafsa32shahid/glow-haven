<?php
// Database connection
$host = 'localhost'; // Replace with your database host
$dbname = 'glow&haven'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $topProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display the report
    echo "<h2>Top 10 Best Selling Products</h2>";
    echo "<table border='1'>";
    echo "<thead><tr><th>Product Name</th><th>Total Quantity Sold</th></tr></thead>";
    echo "<tbody>";
    foreach ($topProducts as $product) {
        echo "<tr><td>{$product['product_name']}</td><td>{$product['total_quantity_sold']}</td></tr>";
    }
    echo "</tbody>";
    echo "</table>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>