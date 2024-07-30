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

// Get email from the form
$email = $_POST['email'];

// Prepare and bind
$stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
$stmt->bind_param("s", $email);

// Execute the statement
$stmt->execute();

// Store the result
$stmt->store_result();

// Check if email exists
if ($stmt->num_rows > 0) {
    // Start session and store email
    session_start();
    $_SESSION['email'] = $email;

    // Redirect to change_pass.php
    header("Location: change_pass.php");
    exit(); // Make sure to exit after redirecting
} else {
    // Show a pop-up message and redirect back to the email verification form
    echo "<script>alert('User not found'); window.location.href = 'forgot.php';</script>";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
