<?php require("./inc/header.php"); ?>
<?php require("./inc/bootstrap-inc.php"); ?>
</head>

<body>

<?php
include("../config/connection.php");
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryName = mysqli_real_escape_string($conn, $_POST['categoryName']);
    $categoryDescription = mysqli_real_escape_string($conn, $_POST['categoryDescription']);
    
    // Insert data into the database
    $sql = "INSERT INTO jewelery_categories (name, description) VALUES ('$categoryName', '$categoryDescription')";
    
  if ($conn->query($sql) === TRUE) {
    echo
     "
    
<script>
 
  
    Swal.fire({
      title: 'Success!',
      text: 'Category has been added to the database.',
      icon: 'success',
      confirmButtonText: 'OK',
      timer: 4000, // Automatically close after 3 seconds
      timerProgressBar: true,
    });
</script>
    ";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

$conn->close();
?>


    <div class="fluid-container">
        <div class="row">
            <div class="col-3">
                <?php require("./inc/sidebar.php"); ?>
            </div>
            <div class="col-9">
                <div class="main">
                    <?php require("./inc/topbar.php") ?>
                    <div class="form-container w-100 px-5">
                        <h2 class="logo-text" style="font-size:4rem;">Add New jewelery Category</h2>
                        <form method="POST">
                            <!-- Category Name -->
                            <div class="mb-3">
                                <label for="categoryName" class="form-label">Category Name</label>
                                <input type="text" class="form-control  rounded-5" id="categoryName" name="categoryName"
                                    placeholder="Enter category name" required>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="categoryDescription" class="form-label">Description</label>
                                <textarea class="form-control rounded-5" id="categoryDescription" name="categoryDescription"
                                    rows="3" placeholder="Enter a brief description"></textarea>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn button">Add Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php require("./inc/footer.php"); ?>