<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    // Server-side validation
    if (empty($name) || empty($email) || empty($message)) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'All fields are required!'
                }).then(() => window.history.back());
              </script>";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Email',
                    text: 'Please enter a valid email address!'
                }).then(() => window.history.back());
              </script>";
        exit();
    }

    // Insert into database using prepared statement
    $stmt = $conn->prepare("INSERT INTO contacts (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Message Sent!',
                    text: 'Your message has been sent successfully!',
                    confirmButtonColor: '#3085d6'
                }).then(() => window.location.href='contact-us.php');
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong, please try again!'
                }).then(() => window.history.back());
              </script>";
    }


}
?>