

<?php
require("./inc/header.php");
require("./inc/bootstrap-inc.php");?>
<script>
    // JavaScript to dynamically add shade inputs
    function addShade() {
        const shadesDiv = document.getElementById("shades");
        const shadeInput = document.createElement("div");
        shadeInput.innerHTML = `
           <div class="shade-input">
    <input type="text" class="form-control" name="shade_names[]" placeholder="Shade Name" required>
    <br>
    <input type="file" class="form-control" name="shade_images[]" accept="image/*" required>
    <br>
    <button type="button" class="btn btn-danger btn-sm mt-2" onclick="this.parentElement.remove()">Remove</button>
    <br><br>
</div>

        `;
        shadesDiv.appendChild(shadeInput);
    }
</script>
</head>
<body>

<?php
// Retrieve the product name from the query string
$product_name = isset($_GET['product_name']) ? $_GET['product_name'] : '';
$subcategory_id = isset($_GET['subcategory_id']) ? $_GET['subcategory_id'] : '';
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "glow&haven";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get shade details
    $product_name = $_POST['product_name'];
    $shade_names = $_POST['shade_names'];
    $shade_images = $_FILES['shade_images']['name'];

    $product_query = $conn->prepare("SELECT id FROM cosmet_products WHERE product_name = ?");
    $product_query->bind_param("s", $product_name);
    $product_query->execute();
    $result = $product_query->get_result();
    $product = $result->fetch_assoc();
    $product_id = $product['id'];

    // Insert shades into the database
    foreach ($shade_names as $index => $shade_name) {
        $shade_image = $shade_images[$index];
        $shade_image_path = "cosm-categories/{$subcategory_id}/{$product_name}/shades/{$shade_image}";

        // Create shades directory if it doesn't exist
        if (!file_exists(dirname($shade_image_path))) {
            mkdir(dirname($shade_image_path), 0777, true);
        }

        // Move uploaded shade image
        move_uploaded_file($_FILES['shade_images']['tmp_name'][$index], $shade_image_path);

        // Insert shade into the database
        $sql = "INSERT INTO shades (product_id, shade_name, shade_image) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $product_id, $shade_name, $shade_image_path);
        $stmt->execute();
    }

    echo "
        <script>
            Swal.fire({
              title: 'Success!',
              text: 'Shades have been added to the product.',
              icon: 'success',
              confirmButtonText: 'OK',
              timer: 3000,
              timerProgressBar: true,
            });
        </script>
    ";
}

$conn->close();
?>

<body>
    <div class="fluid-container">
        <div class="row">
            <div class="col-3">
                <?php require("./inc/sidebar.php"); ?>
            </div>
            <div class="col-9">
                <div class="main">
                    <?php require("./inc/topbar.php") ?>
                    <div class="form-contain p-5">
                        <h2 class="logo-text" style="font-size:4rem;">Add Shades for Product: <span class="fs-4 text-black"><?php echo $product_name; ?></span></h2>
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="product_name" value="<?php echo $product_name; ?>">

                            <div id="shades">
                                <input type="text" name="shade_names[]" class="form-control" placeholder="Shade Name" required>
                                <br>
                                <input type="file" name="shade_images[]" class="form-control" accept="image/*" required>
                                <br>
                            </div>

                            <button type="button" class="btn button rounded-5 w-auto" onclick="addShade()">Add Another Shade</button>
                            <br><br>
                            <button type="submit" class="btn button rounded-5">Add Shades</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require("./inc/footer.php"); ?>
</body>
