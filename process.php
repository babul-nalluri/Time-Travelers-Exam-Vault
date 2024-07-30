<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
<?php 
session_set_cookie_params(3600);
session_start(); 
include "db_conn.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {
  // echo "User login successful";
    function validate($data)
    {
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);
   

    $adminUsername = 'admin';
    $adminPassword = 'admin@123';

    if ($uname === $adminUsername && $pass === $adminPassword) 
    {
        // Authentication successful
        $_SESSION['admin'] = true;
        echo "<script>
        swal('Valid User!!', 'You have successfully logged in as Admin.', 'success').then(() => {
            window.location.href = 'user.html'; // Redirect to the user page
        });
    </script>";
        exit();
    }

    if (empty($uname)) {
        echo "<script>swal('Error', 'User Name is required', 'error').then(() => { window.location.href = 'login.php'; });</script>";
        exit();
    } else if (empty($pass)){
        echo "<script>swal('Error', 'Password is required', 'error').then(() => { window.location.href = 'login.php'; });</script>";
        exit();
    } 
    else {
        $sql = "SELECT * FROM user WHERE username='$uname'";
      
        $result = mysqli_query($conn, $sql);

        if (!$result) 
        {
            exit();
        }
        $flag=0;
        $num_rows = mysqli_num_rows($result);
        if ($num_rows == 1) 
        {
            $row = mysqli_fetch_assoc($result);
            // Compare the input password with the hashed password from the database
            if (password_verify($pass, $row['password'])) 
            {
                $_SESSION['username'] = $row['username'];
                $_SESSION['name'] = $row['email'];
                //$_SESSION['id'] = $row['id'];
                $_SESSION['user'] = true;
                echo "<script>
                swal('Valid User!!', 'You have successfully logged in as User.', 'success').then(() => {
                    window.location.href = 'user.html'; // Redirect to the user page
                });
            </script>";
            }
            else 
            {
                echo "<script>
                swal('Invalid Password!!', 'Something went wrong. Please try again!', 'error').then(() => {
                window.location.href = 'login.php'; // Redirect to the login page
            });
            
        </script>";
        }
        } elseif ($num_rows == 0) {
            echo "<script>alert('User not found');</script>";
            exit();
        } else 
        {
            // Multiple users found
            echo "<script>alert('Multiple users found for the same username');</script>";
            exit();
        }
    }
} else {
    header("Location: login.php");
    exit();
}
?>





</body>
<html>
