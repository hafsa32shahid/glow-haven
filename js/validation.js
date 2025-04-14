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
        alert('Form submitted successfully!');
        // Uncomment the line below to submit the form
        // this.submit();
    }
});

document.getElementById('loginForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent form submission

    // Clear previous errors
    document.querySelectorAll('.text-danger').forEach(function (el) {
        el.classList.add('d-none');
    });

    let isValid = true;



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
   // Submit the form if all validations pass
    if (isValid) {
        alert('Form submitted successfully!');
        // Uncomment the line below to submit the form
        // this.submit();
    }
});
// contacts validation
function validateForm() {
    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let message = document.getElementById("message").value.trim();
    let errorMessage = document.getElementById("error-message");

    if (name === "" || email === "" || message === "") {
        errorMessage.innerHTML = "All fields are required!";
        return false;
    }

    let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    if (!emailPattern.test(email)) {
        errorMessage.innerHTML = "Please enter a valid email address.";
        return false;
    }

    return true;
}