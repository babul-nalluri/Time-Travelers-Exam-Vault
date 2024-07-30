<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
<?php
// Include db_conn.php to establish the database connection
include "db_conn.php";

// Check if the connection is established successfully
if ($conn) {
    // Attempt to create a PDO connection
    try {
        // Create a new PDO instance
        $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);

        // Set PDO to throw exceptions on error
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        // If an exception occurs, display an error message
        echo "Connection failed: " . $e->getMessage();
        exit(); // Exit the script if the connection failed
    }
} else {
    echo "Connection failed: Unable to connect to the database.";
    exit(); // Exit the script if the connection failed
}

// Check if the HTTP request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['uname'], $_POST['mail'], $_POST['password'], $_POST['re_password'])) {
        $uname = validate($_POST['mail']);
        $name = validate($_POST['uname']);
        $pass = validate($_POST['password']);
        $re_pass = validate($_POST['re_password']);

        if (!validatePassword($pass)) {
            showError("Password must contain at least one uppercase letter, one lowercase letter, one digit, one special character, and have a minimum length of 8 characters");
        } elseif ($pass !== $re_pass) {
            showError("Passwords do not match");
        } else {
            // Query the database to check if the username already exists
            $query = "SELECT * FROM user WHERE username = :username";
            $statement = $pdo->prepare($query);
            $statement->bindParam(':username', $name, PDO::PARAM_STR);
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            // Check if the username exists
            if ($result) {
                showError("Username already exists");
            } else {
                // Hash the password
                $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

                // Insert the user into the database
                $stmt = $pdo->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
                if (!$stmt) {
                    showError("Database error: " . $pdo->errorInfo()[2]);
                }
                $stmt->bindParam(1, $name);
                $stmt->bindParam(2, $uname);
                $stmt->bindParam(3, $hashed_password);

                if ($stmt->execute()) {
                    showSuccess("Your account has been created successfully");
                } else {
                    showError("Database error: " . $stmt->errorInfo()[2]);
                }
                $stmt->closeCursor();
            }
        }
    } else {
        showError("All fields are required");
    }
} else {
    header("Location: signup.php");
    exit();
}

// Function to validate and sanitize input
function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to validate password
function validatePassword($password) {
    return preg_match('@[A-Z]@', $password) &&
           preg_match('@[a-z]@', $password) &&
           preg_match('@[0-9]@', $password) &&
           preg_match('@[^\w]@', $password) &&
           strlen($password) >= 8;
}

// Function to show error message
function showError($message) {
    echo "<script>
            alert('$message');
            window.location.href = 'signup.php';
          </script>";
    exit();
}

// Function to show success message
function showSuccess($message) {
    echo "<script>
            alert('$message');
            window.location.href = 'login.php';
          </script>";
    exit();
}
?>



</body>
</html>
