<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Setting</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <div class="wrapper">
        <form action="process5.php" method="post">
            <h2>Set New Password</h2>

            <div class="input-box">
                <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                <input type="password" placeholder="New Password" name="new_password" required>
            </div>

            <div class="input-box">
                <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                <input type="password" placeholder="Confirm Password" name="confirm_password" required>
            </div>

            <button type="submit" class="btn">Set Password</button><br><br>
            <div class="back-to-login">
                <a href="login.php">Back to Login</a>
            </div>
        </form>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
