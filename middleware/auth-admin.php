<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    echo "<script>
            Swal.fire({ icon: 'error', title: 'Access Denied', text: 'You do not have permission to access this page!' })
            .then(() => window.location.href = './admin/index.php');
          </script>";
    exit;
}
?>
