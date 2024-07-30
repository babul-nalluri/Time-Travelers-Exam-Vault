<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get new passwords from the form
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// Validate passwords
if ($new_password !== $confirm_password) {
    echo "<script>alert('Passwords do not match'); window.location.href = 'change_pass.php';</script>";
    exit();
}

// Hash the new password
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// Start session and get the email of the user
session_start();
$email = $_SESSION['email'];

if (!$email) {
    echo "<script>alert('Session expired. Please try again.'); window.location.href = 'forgot.php';</script>";
    exit();
}

// Prepare and bind
$stmt = $conn->prepare("UPDATE user SET password = ? WHERE email = ?");
$stmt->bind_param("ss", $hashed_password, $email);

// Execute the statement
if ($stmt->execute()) {
    echo "<script>alert('Password successfully updated'); window.location.href = 'login.php';</script>";
} else {
    echo "<script>alert('Error updating password'); window.location.href = 'change_pass.php';</script>";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
