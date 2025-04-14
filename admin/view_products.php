<?php
include '../config/connection.php';

// Fetch cosmetics
$cosmetics_query = "SELECT *, 'cosmetics' AS type FROM cosmet_products";
$cosmetics_result = mysqli_query($conn, $cosmetics_query);
$cosmetics = mysqli_fetch_all($cosmetics_result, MYSQLI_ASSOC); // Fetch all cosmetics as an associative array

// Fetch jewelry
$jewelry_query = "SELECT *, 'jewelry' AS type FROM jewelry_products";
$jewelry_result = mysqli_query($conn, $jewelry_query);
$jewelry = mysqli_fetch_all($jewelry_result, MYSQLI_ASSOC); // Fetch all jewelry as an associative array
?>

<?php include("./inc/header.php") ?>

<div class="fluid-container">
    <div class="row">
        <div class="col-3">
            <?php require("./inc/sidebar.php"); ?>
        </div>
        <div class="col-9">
            <div class="main">
                <?php include("./inc/topbar.php") ?>
                <div class="detail">
                    <div class="recentOrders p-5">
                        <!-- Cosmetics Table -->
                        <div class="cardHeader">
                            <h2>Cosmetics</h2>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>Image</td>
                                    <td>Name</td>
                                    <td>Price</td>
                                    <td>Stock</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cosmetics as $product): ?>
                                <tr>
                                    <td>
                                        <div class="img" style="width:50px;height:50px">
                                            <img src="./<?php echo htmlspecialchars($product['product_image']); ?>" class="w-100" alt="">
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                                    <td>Rs: <?php echo htmlspecialchars($product['product_price']); ?></td>
                                    <td><?php echo htmlspecialchars($product['stock']); ?></td>
                                    <td>
                                        <a class="btn btn-info" href="edit-product.php?type=<?php echo $product['type']; ?>&id=<?php echo $product['id']; ?>">Edit</a>
                                        <a class="btn btn-danger delete-button" data-type="<?php echo $product['type']; ?>" data-id="<?php echo $product['id']; ?>" href="#">Delete</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <!-- Jewelry Table -->
                        <div class="cardHeader mt-5">
                            <h2>Jewelry</h2>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>Image</td>
                                    <td>Name</td>
                                    <td>Price</td>
                                    <td>Stock</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($jewelry as $product): ?>
                                <tr>
                                    <td>
                                        <div class="img" style="width:50px;height:50px">
                                            <img src="./<?php echo htmlspecialchars($product['product_image']); ?>" class="w-100" alt="">
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                                    <td>Rs: <?php echo htmlspecialchars($product['product_price']); ?></td>
                                    <td><?php echo htmlspecialchars($product['stock']); ?></td>
                                    <td>
                                        <a class="btn btn-info" href="edit-product.php?type=<?php echo $product['type']; ?>&id=<?php echo $product['id']; ?>">Edit</a>
                                        <a class="btn btn-danger delete-button" data-type="<?php echo $product['type']; ?>" data-id="<?php echo $product['id']; ?>" href="#">Delete</a>

                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript for SweetAlert Delete Confirmation
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault(); // Prevent default link behavior
            const type = this.getAttribute('data-type');
            const id = this.getAttribute('data-id');

            // SweetAlert2 confirmation dialog
            Swal.fire({
                title: `Are you sure?`,
                text: `You won't be able to revert this ${type} product deletion!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to the delete.php page if confirmed
                    window.location.href = `dlete-pro.php?type=${type}&id=${id}`;
                }
            });
        });
    });
</script>


<?php include("./inc/footer.php") ?>
