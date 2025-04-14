<?php require("./includes/header.php") ?>

<?php
session_start();
require("./config/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $rememberMe = isset($_POST['rememberMe']) ? true : false;

    if (empty($email) || empty($password)) {
        echo "<script>
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'Please fill in all fields!' })
                .then(() => window.location.href = 'login.php');
              </script>";
        exit;
    }

    // Prepare SQL statement
    $sql = "SELECT id, email, password, role FROM users WHERE email = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $email, $db_password, $role);
            if ($stmt->fetch()) {
                if ($password === $db_password) { // Change to password_verify() if hashed
                    session_regenerate_id();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['id'] = $id;
                    $_SESSION['email'] = $email;
                    $_SESSION['role'] = $role;

                    if ($rememberMe) {
                        $cookieValue = base64_encode("$email:$password");
                        setcookie("rememberMeCookie", $cookieValue, time() + (86400 * 30), "/");
                    }

                    // Redirect based on role
                    if ($role == 'admin') {
                        echo "<script>
                                Swal.fire({ icon: 'success', title: 'Admin Login Successful!', text: 'Redirecting to panel...', timer: 1500 })
                                .then(() => window.location.href = './admin/index.php');
                              </script>";
                    } else {
                        echo "<script>
                                Swal.fire({ icon: 'success', title: 'Login Successful!', text: 'Redirecting...', timer: 1500 })
                                .then(() => window.location.href = 'index.php');
                              </script>";
                    }
                    exit;
                } else {
                    echo "<script>
                            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Invalid password!' })
                            .then(() => window.location.href = 'login.php');
                          </script>";
                    exit;
                }
            }
        } else {
            echo "<script>
                    Swal.fire({ icon: 'error', title: 'Oops...', text: 'No account found with that email!' })
                    .then(() => window.location.href = 'login.php');
                  </script>";
            exit;
        }
        $stmt->close();
    }
    $conn->close();
}
?>


<!-- Main Content Section -->
<section class="d-flex flex-column" style="min-height: 100vh;">
  <div class="container-fluid flex-grow-1">
    <div class="row d-flex justify-content-center align-items-center h-100 mt-5">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="https://img.freepik.com/premium-vector/woman-stands-near-smartphone-screen-login-page-user-profile-access-account-concept_123447-5769.jpg?ga=GA1.1.24328383.1694452068&semt=ais_hybrid"
          class="img-fluid" alt="Sample image">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form id="loginForm" method="post">
          <h2 class="text-center mb-4 logo-text animate__animated animate__fadeInDown" style="font-size:4rem;">Login</h2>
          <!-- Email input -->
          <div data-mdb-input-init class="form-outline mb-4">
            <input type="email" id="email" name="email" class="form-control form-control-lg rounded-5"
              placeholder="Enter a valid email address" />
            <label class="form-label ms-3" for="form3Example3">Email address</label><br>
            <small id="emailError" class="text-danger d-none mt-2 ms-2">Please enter a valid email address.</small>
          </div>

          <!-- Password input -->
          <div data-mdb-input-init class="form-outline mb-3">
            <input type="password" id="password" class="form-control form-control-lg rounded-5"
              placeholder="Enter password" name="password" />
            <label class="form-label ms-3" for="form3Example4">Password</label><br>
            <small id="passwordError" class="text-danger d-none mt-2 ms-2">"Password must be at least 8 characters long, include letters, numbers, and special characters."</small>
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <!-- Checkbox -->
            <div class="form-check mb-0">
              <input class="form-check-input me-2 rounded-5" name="rememberMe" type="checkbox" value="" id="form2Example3" />
              <label class="form-check-label ms-3" for="form2Example3">
                Remember me
              </label>
            </div>
            <a href="#!" class="text-body">Forgot password?</a>
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
            <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn button w-100 btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem;" name="login" >Login</button>
            <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="register.php"
                class="link-primary">Register</a></p>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="py-4 px-4 px-xl-5" style="background-color: #eb3477;">
    <div class="container-fluid">
      <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
        <!-- Copyright -->
        <div class="text-white mb-3 mb-md-0">
          Copyright © 2025. All rights reserved.
        </div>
        <!-- Right -->
        <div>
          <a href="#!" class="text-white me-4">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="#!" class="text-white me-4">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="#!" class="text-white me-4">
            <i class="fab fa-google"></i>
          </a>
          <a href="#!" class="text-white">
            <i class="fab fa-linkedin-in"></i>
          </a>
        </div>
      </div>
    </div>
  </footer>
</section>

<script src="./js/validation.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if the "Remember Me" cookie exists
        const rememberMeCookie = document.cookie.split('; ').find(row => row.startsWith('rememberMeCookie='));
        if (rememberMeCookie) {
            const cookieValue = decodeURIComponent(rememberMeCookie.split('=')[1]);
            const [email, password] = atob(cookieValue).split(':'); // Decode and split the cookie value

            // Auto-fill the form fields
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
    });
</script>
<?php require("./includes/html-close.php") ?>