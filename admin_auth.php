<?php
session_start();

// Dummy admin credentials
$admin_username = "admin";
$admin_password = "admin123";  

// Get user input
$username = $_POST['admin_username']; 
$password = $_POST['admin_password'];  

// Check if admin credentials match
if ($username === $admin_username && $password === $admin_password) {
    $_SESSION['admin'] = true; // Set session variable
    header("Location: admin_dashboard.php");  // Redirect to admin dashboard
    exit();
} else {
    echo "<script>alert('Access Denied: Only admins allowed'); window.location.href = 'admin.php';</script>";
}
?>