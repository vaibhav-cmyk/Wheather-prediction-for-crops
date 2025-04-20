<?php
include "db.php";

// Ensure that form data exists
if (isset($_POST['name'], $_POST['email'], $_POST['password'])) {
    
    // Get the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Sanitize email (You might want to validate the email format)
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email exists
        echo "<script>alert('Email already exists!'); window.location='register.html';</script>";
    } else {
        // Email does not exist, proceed with registration
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashed_password);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful!'); window.location='index.html';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "'); window.location='register.html';</script>";
        }
    }

    // Close the statement
    $stmt->close();
} else {
    echo "<script>alert('Please fill all fields.'); window.location='register.html';</script>";
}

$conn->close();
?>
