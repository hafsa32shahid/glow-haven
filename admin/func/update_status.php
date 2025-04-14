<?php
include('../../config/connection.php');

if (isset($_POST['order_id']) && isset($_POST['new_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];

    $stmt = $conn->prepare("UPDATE orders SET o_status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $order_id);

    if ($stmt->execute()) {
        echo "<script>
            alert('Order status updated successfully!');
            window.location.href = '../orders.php';
            </script>";
    } else {
        echo "<script>
            alert('Failed to update order status.');
            window.location.href = '../orders.php';
            </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
