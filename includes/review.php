<?php
include("./config/connection.php");

if (isset($_POST['submit_review'])) {
    // Check if the user is logged in
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        echo "<script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Login Required',
                    text: 'You must be logged in to submit a review.',
                    confirmButtonText: 'Login'
                }).then(() => {
                    window.location.href = 'login.php'; 
                });
              </script>";
        exit;
    }

    // Get and validate product ID
    $product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : null;
    $category = isset($_GET['category']) ? $_GET['category'] : null;

    if (!$product_id || !$category) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Request',
                    text: 'Product ID or category is missing.'
                });
              </script>";
        exit;
    }

    // Get user ID from session
    $user_id = $_SESSION['id'];

    // Sanitize and validate inputs
    $full_name = htmlspecialchars($_POST['full_name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $rating = intval($_POST['rating']);
    $comments = htmlspecialchars($_POST['reviews']);

    // Validate if product exists in the correct category
    if ($category === 'cosmetics') {
        $stmt = $conn->prepare("SELECT id FROM cosmet_products WHERE id = ?");
    } elseif ($category === 'jewelry') {
        $stmt = $conn->prepare("SELECT id FROM jewelry_products WHERE id = ?");
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Category',
                    text: 'The provided category is invalid.'
                });
              </script>";
        exit;
    }

    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result->fetch_assoc()) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Product',
                    text: 'The product ID is invalid for the given category.'
                });
              </script>";
        exit;
    }

    // Insert the review if all fields are valid
    if ($full_name && $email && $rating && $comments) {
        $sql = "INSERT INTO product_reviews (product_id, user_id, full_name, email, rating, reviews, category) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iississ", $product_id, $user_id, $full_name, $email, $rating, $comments, $category);

        if ($stmt->execute()) {
            // Determine redirect URL
            $redirect_url = ($category === 'jewelry' && isset($_GET['category_id'])) 
                ? "jewe-detail.php?product_id={$product_id}&category_id=" . intval($_GET['category_id']) . "&category=jewelry"
                : "product-detail.php?product_id={$product_id}&category=cosmetics";

            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Review Submitted',
                        text: 'Your review has been successfully submitted!',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = '$redirect_url';
                    });
                  </script>";
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to submit the review. Please try again later.'
                    });
                  </script>";
        }
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Missing Fields',
                    text: 'Please fill in all required fields.'
                });
              </script>";
    }
}
?>


<section class="review-form my-5">
  <div class="container">
    <h2 class="text-center mb-4 logo-text" style="font-size:3.5rem;">Submit Your Review</h2>
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8 col-sm-12">
        <form method="post">
          <!-- Name -->
          <div class="mb-3">
            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control rounded-4" id="name" name="full_name" value=""
              placeholder="Enter your name" required>
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
            <input type="email" class="form-control rounded-4" id="email" name="email" value=""
              placeholder="Enter your email" required>
          </div>

          <!-- Rating -->
          <div class="mb-3">
            <label for="rating" class="form-label">Rating <span class="text-danger">*</span></label>
            <select class="form-select rounded-4" id="rating" required name="rating">
              <option value="" disabled selected>Choose a rating</option>
              <option value="5">5 - Excellent</option>
              <option value="4">4 - Very Good</option>
              <option value="3">3 - Good</option>
              <option value="2">2 - Fair</option>
              <option value="1">1 - Poor</option>
            </select>
          </div>

          <!-- Comments -->
          <div class="mb-3">
            <label for="comments" class="form-label">Comments <span class="text-danger">*</span></label>
            <textarea class="form-control rounded-4" name="reviews" rows="4" placeholder="Write your review here"
              required></textarea>
          </div>

          <!-- Submit Button -->
          <div class="d-grid">
            <button type="submit" name="submit_review" class="btn button w-auto btn-lg">Submit Review</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>