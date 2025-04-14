<?php
include '../config/connection.php';

$type = $_GET['type']; // 'cosmetics' or 'jewelry'
$id = $_GET['id'];

// Ensure the id is an integer for safety
$id = intval($id);

if ($type === 'cosmetics') {
    $stmt = $conn->prepare("DELETE FROM cosmet_products WHERE id = ?");
} else {
    $stmt = $conn->prepare("DELETE FROM jewelry_products WHERE id = ?");
}

// Bind the parameter
$stmt->bind_param("i", $id);

// Execute the statement
$stmt->execute();

// Redirect to the products page
header("Location: view_products.php");
exit();
?>
