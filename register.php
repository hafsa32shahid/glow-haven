<?php
// Include database connection
require("./config/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs directly as JavaScript handles validation
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['cpassword']);
    $gender = trim($_POST['gender']);
    $dob = trim($_POST['date_of_birth']);

    // // Hash the password for security
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL query to insert user data
    $sql = "INSERT INTO users (fullname, email, password, gender, date_of_birth) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssss", $fullname, $email, $password, $gender, $dob);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!');</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Error preparing statement: " . $conn->error . "');</script>";
    }

    $conn->close();
}
?>

<?php require("./includes/header.php") ?>

<!-- Main Content Section -->
<section class="d-flex flex-column justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="container-fluid flex-grow-1">
        <div class="row justify-content-center align-items-center flex-row h-100 mt-5">
            <!-- Image Column -->
            <div class="col-md-12 col-lg-5 d-none d-md-block"> <!-- Hide on small screens -->
                <img src="https://img.freepik.com/premium-vector/woman-stands-near-smartphone-screen-login-page-user-profile-access-account-concept_123447-5769.jpg?ga=GA1.1.24328383.1694452068&semt=ais_hybrid"
                    class="img-fluid" alt="Sample image">
            </div>

            <!-- Form Column -->
            <div class="col-md-12 col-lg-7 p-5">
                <form id="registerForm" method="post">
                    <h2 class="text-center mb-4 logo-text animate__animated animate__fadeInDown"
                        style="font-size:2.5rem;">Register</h2>
                    <div class="row">
                        <!-- Full Name Input -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div data-mdb-input-init class="form-outline mb-3">
                                <input type="text" id="fullName" class="form-control form-control-lg rounded-5"
                                    placeholder="Enter your full name" name="fullname" required />
                                <label class="form-label ms-3" for="fullName">Full Name</label><br>
                                <small id="fullNameError" class="text-danger d-none mt-2 ms-2">Full name must contain only letters and spaces.</small>
                            </div>
                        </div>

                        <!-- Email Input -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div data-mdb-input-init class="form-outline mb-3">
                                <input type="email" id="email" class="form-control form-control-lg rounded-5"
                                    placeholder="Enter a valid email address" name="email" required />
                                <label class="form-label ms-3" for="email">Email Address</label><br>
                                <small id="emailError" class="text-danger d-none mt-2 ms-2">Please enter a valid email address.</small>
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div data-mdb-input-init class="form-outline mb-3">
                                <input type="password" id="password" class="form-control form-control-lg rounded-5"
                                    placeholder="Enter password" name="password" required />
                                <label class="form-label ms-3" for="password">Password</label><br>
                                <small id="passwordError" class="text-danger d-none mt-2 ms-2">Password must be at least 8 characters long, include letters, numbers, and special characters.</small>
                            </div>
                        </div>

                        <!-- Confirm Password Input -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div data-mdb-input-init class="form-outline mb-3">
                                <input type="password" id="confirmPassword"
                                    class="form-control form-control-lg rounded-5" name="cpassword" placeholder="Confirm password" required />
                                <label class="form-label ms-3" for="confirmPassword">Confirm Password</label><br>
                                <small id="confirmPasswordError" class="text-danger d-none mt-2 ms-2">Passwords do not match.</small>
                            </div>
                        </div>

                        <!-- Date of Birth Input -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div data-mdb-input-init class="form-outline mb-3">
                                <input type="date" id="dob" class="form-control form-control-lg rounded-5" name="date_of_birth" required />
                                <label class="form-label ms-3" for="dob">Date of Birth</label><br>
                                <small id="dobError" class="text-danger d-none mt-2 ms-2">You must be at least 18 years old.</small>
                            </div>
                        </div>

                        <!-- Gender Selection -->
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div data-mdb-input-init class="form-outline mb-3">
                                <select id="gender" class="form-control form-control-lg rounded-5" name="gender" required>
                                    <option value="" disabled selected>Select your gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                                <label class="form-label ms-3" for="gender">Gender</label><br>
                                <small id="genderError" class="text-danger d-none mt-2 ms-2">Please select your gender.</small>
                            </div>
                        </div>
                    </div>

                    <!-- Terms and Conditions Checkbox -->
                    <div class="form-check mb-4">
                        <input class="form-check-input me-2" type="checkbox" value="" id="terms" required />
                        <label class="form-check-label" for="terms">
                            I agree to the <a href="#!" class="text-primary">terms and conditions</a>
                        </label><br>
                        <small id="termsError" class="text-danger d-none mt-2 ms-2">You must agree to the terms and conditions.</small>
                    </div>

                    <!-- Register Button -->
                    <div class="text-center text-lg-start mt-4 pt-2">
                        <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn button w-100 btn-lg"
                            style="padding-left: 2.5rem; padding-right: 2.5rem;" name="register">Register</button>
                        <p class="small fw-bold mt-2 pt-1 mb-0">Already have an account? <a href="login.php"
                                class="link-primary">Login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-4 px-4 px-xl-5 w-100" style="background-color: #eb3477;">
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


<!-- JavaScript for Validation and SweetAlert -->
<script>
    document.getElementById('registerForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent form submission

      // Clear previous errors
    document.querySelectorAll('.text-danger').forEach(function (el) {
        el.classList.add('d-none');
    });

    let isValid = true;

    // Full Name Validation
    const fullName = document.getElementById('fullName').value;
    const fullNameRegex = /^[A-Za-z\s]+$/;
    if (!fullNameRegex.test(fullName)) {
        document.getElementById('fullNameError').classList.remove('d-none');
        isValid = false;
    }

    /// Email Validation
const email = document.getElementById('email').value;
const emailRegex = /^[a-zA-Z][a-zA-Z0-9._%+-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
if (!emailRegex.test(email)) {
    document.getElementById('emailError').classList.remove('d-none');
       
    isValid = false;
} 

   // Password Validation
const password = document.getElementById('password').value;
const passwordRegex = /^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
if (!passwordRegex.test(password)) {
    document.getElementById('passwordError').classList.remove('d-none');
    isValid = false;
}

    // Confirm Password Validation
    const confirmPassword = document.getElementById('confirmPassword').value;
    if (password !== confirmPassword) {
        document.getElementById('confirmPasswordError').classList.remove('d-none');
        isValid = false;
    }

    // Date of Birth Validation
    const dob = document.getElementById('dob').value;
    const dobDate = new Date(dob);
    const today = new Date();
    const age = today.getFullYear() - dobDate.getFullYear();
    if (age < 18) {
        document.getElementById('dobError').classList.remove('d-none');
        isValid = false;
    }

    // Gender Validation
    const gender = document.getElementById('gender').value;
    if (!gender) {
        document.getElementById('genderError').classList.remove('d-none');
        isValid = false;
    }

    // Terms and Conditions Validation
    const terms = document.getElementById('terms').checked;
    if (!terms) {
        document.getElementById('termsError').classList.remove('d-none');
        isValid = false;
    }

        // Submit the form if all validations pass
        if (isValid) {
            Swal.fire({
                title: 'Success!',
                text: 'Registration successful!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                // Submit the form
                this.submit();
            });
        } else {
            Swal.fire({
                title: 'Error!',
                text: 'Please fix the errors in the form.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    });
</script>

<?php require("./includes/html-close.php") ?>