<?php require("./inc/header.php"); ?>
<?php require("./inc/bootstrap-inc.php"); ?>
</head>

<body>

    <?php
   include("../config/connection.php");
    // Handle form submission
    if (isset($_POST["add-categ"])) {
        $cosmeticName = $_POST['cosmeticName'];
        //   $cosmeticDescription = $_POST['cosmeticDescription'];
    
        // Insert data into the database
        $sql = "INSERT INTO cosmetic_categ (cosmet_name) VALUES ('$cosmeticName')";
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
                        <h2 class="logo-text" style="font-size:4rem;">Add New Cosmetics Category</h2>
                        <form method="POST">
                            <!-- Category Name -->
                            <div class="mb-3">
                                <label for="categoryName" class="form-label">Category Name</label>
                                <input type="text" class="form-control  rounded-5" id="categoryName" name="cosmeticName"
                                    placeholder="Enter category name" required>
                            </div>


                            <!-- Submit Button -->
                            <button type="submit" class="btn button" name="add-categ">Add Category</button>
                        </form>
                    </div>


                    <?php
                    if (isset($_POST["add-sub"])) {

                        // Get input values
                        $category_id = $_POST['category_id'];
                        $subcategory_name = $_POST['subcategory_name'];
                        $sub_categ_disc = $_POST['sub_categ_disc'];

                        // Validate inputs (Prevent empty values)
                        if (empty($category_id) || empty($subcategory_name) || empty($sub_categ_disc)) {
                            echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'All fields are required.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>";
                            exit();
                        }

                        // **Step 1: Check if category_id exists in cosmetic_categ**
                        $check_category_sql = "SELECT cosmet_id FROM cosmetic_categ WHERE cosmet_id = ?";
                        $check_category_stmt = $conn->prepare($check_category_sql);
                        $check_category_stmt->bind_param("i", $category_id);
                        $check_category_stmt->execute();
                        $check_category_stmt->store_result();

                        if ($check_category_stmt->num_rows == 0) {
                            echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'Selected category does not exist.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>";
                            exit();
                        }
                        $check_category_stmt->close();

                        // **Step 2: Check if subcategory already exists**
                        $check_subcategory_sql = "SELECT subcategory_name FROM cosm_subcategories WHERE category_id = ? AND subcategory_name = ?";
                        $check_subcategory_stmt = $conn->prepare($check_subcategory_sql);
                        $check_subcategory_stmt->bind_param("is", $category_id, $subcategory_name);
                        $check_subcategory_stmt->execute();
                        $check_subcategory_stmt->store_result();

                        if ($check_subcategory_stmt->num_rows > 0) {
                            echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'Subcategory already exists in this category.',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then(function() {
                                window.location.href = 'cosmetics-categ.php';
                            });
        </script>";
                            exit();
                        }
                        $check_subcategory_stmt->close();

                        // **Step 3: Insert subcategory if it does not exist**
                        $sql = "INSERT INTO cosm_subcategories (category_id, subcategory_name, disc) VALUES (?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("iss", $category_id, $subcategory_name, $sub_categ_disc);

                        if ($stmt->execute()) {
                            echo "<script>
                            Swal.fire({
                                title: 'Success!',
                                text: 'Subcategory has been added to the database.',
                                icon: 'success',
                                confirmButtonText: 'OK',
                                timer: 4000,
                                timerProgressBar: true
                            })
                        </script>";
                        
                        } else {
                            echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'Something went wrong! Please try again.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>";
                        }

                        // Close statements & connection
                        $stmt->close();
                        $conn->close();
                    }
                    ?>




                    <div class="sub-categ p-5">
                        <h2 class="logo-text" style="font-size:4rem;">Add New subcategory of Category for cosmetic</h2>
                        <form method="POST">
                            <label for="category_id">Select Category:</label>
                            <select id="category_id" class="form-select" aria-label="Default select example"
                                name="category_id" required>
                                <option value="select category">Selelect category</option>
                                <?php // Database connection
                                $servername = "localhost";
                                $username = "root";
                                $password = "";
                                $dbname = "glow&haven";

                                $conn = new mysqli($servername, $username, $password, $dbname);

                                $result = $conn->query("SELECT * FROM cosmetic_categ");

                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['cosmet_id']}'>{$row['cosmet_name']}</option>";
                                }

                                $conn->close();
                                ?>
                            </select>
                            <br><br>
                            <label for="subcategory_name " class="form-label">Subcategory Name:</label>
                            <input type="text" id="subcategory_name" class="form-control" name="subcategory_name"
                                placeholder="add subcategory" required>
                            <br><br>
                            <label for="categoryDescription" class="form-label">Description</label>
                            <textarea class="form-control rounded-5" id="categoryDescription" name="sub_categ_disc"
                                rows="4" placeholder="Enter a brief description"></textarea>
                            <br><br>
                            <button type="submit" class="btn button w-auto" name="add-sub">Add Subcategory</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php require("./inc/footer.php"); ?>