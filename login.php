<?php
session_start();

include "db.php";

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        // Initialize the session array if it doesn't exist
        if (!isset($_SESSION['users'])) {
            $_SESSION['users'] = [];
        }

        // Add the current user to the session array
        $_SESSION['users'][] = [
            'name' => $user['name'],
            'email' => $email
        ];

        // Store the current user's name and email for immediate access
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $email;

        header("Location: wheather.php");
    } else {
        echo "<script>alert('Invalid password');window.location='index.html';</script>";
    }
} else {
    echo "<script>alert('User  not found');window.location='index.html';</script>";
}

$conn->close();
?>