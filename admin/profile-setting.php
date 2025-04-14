<?php 
session_start();
require("./inc/header.php");
require("../config/connection.php");

// Ensure the admin is logged in
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$adminId = $_SESSION['id'];
$adminData = [];

// Fetch admin details
$sql = "SELECT fullname, email, password FROM users WHERE id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $adminId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $adminData = $result->fetch_assoc();
    }
    $stmt->close();
}

// Handle profile update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newName = trim($_POST['adminName']);
    $newEmail = trim($_POST['adminEmail']);
    $newPassword = trim($_POST['adminPassword']);

    // Validate fields
    if (empty($newName) || empty($newEmail)) {
        echo "<script>Swal.fire('Error', 'Name and Email are required!', 'error');</script>";
    } else {
        $updateSQL = "UPDATE users SET fullname = ?, email = ?" . (!empty($newPassword) ? ", password = ?" : "") . " WHERE id = ?";
        if ($stmt = $conn->prepare($updateSQL)) {
            if (!empty($newPassword)) {
                $stmt->bind_param("sssi", $newName, $newEmail, $newPassword, $adminId);
            } else {
                $stmt->bind_param("ssi", $newName, $newEmail, $adminId);
            }
            if ($stmt->execute()) {
                $_SESSION['email'] = $newEmail; // Update session email
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                echo "<script>
                        Swal.fire('Success', 'Profile updated successfully!', 'success')
                        .then(() => window.location.href = 'profile-setting.php');
                      </script>";
            } else {
                die("Execution failed: " . $stmt->error);
            }
            $stmt->close();
        }
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
                <div class="container mt-5">
                    <div class="profile-header animated text-center">
                        <img src="https://img.freepik.com/free-photo/happy-successful-muslim-businesswoman-posing-outside_74855-2007.jpg?ga=GA1.1.24328383.1694452068&semt=ais_hybrid" alt="Profile Picture">
                        <h2 class="mt-3"><?= htmlspecialchars($adminData['fullname'] ?? 'Admin Name') ?></h2>
                        <p><?= htmlspecialchars($adminData['email'] ?? 'admin@example.com') ?></p>
                        <p>Admin Role</p>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card animated">
                                <div class="card-header">
                                    <h5>Update Profile Information</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST">
                                        <div class="form-group">
                                            <label for="adminName">Name</label>
                                            <input type="text" class="form-control" id="adminName" name="adminName" 
                                            value="<?= htmlspecialchars($adminData['name'] ?? '') ?>" required>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="adminEmail">Email</label>
                                            <input type="email" class="form-control" id="adminEmail" name="adminEmail" 
                                            value="<?= htmlspecialchars($adminData['email'] ?? '') ?>" required>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="adminPassword">New Password (optional)</label>
                                            <input type="password" class="form-control" id="adminPassword" name="adminPassword" 
                                            placeholder="Enter new password (leave blank to keep old one)">
                                        </div>
                                        <button type="submit" class="btn button mt-3">Update Profile</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require("./inc/footer.php"); ?>
