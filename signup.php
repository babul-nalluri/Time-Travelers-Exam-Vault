<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignUp Form</title>
    <link rel="stylesheet" href="signup.css">
</head>

<body>
    
    <div class="wrapper">
        <form action="process1.php" method="post">
            <h2>SignUp</h2>
            <div class="input-box">
                <span class="icon"><ion-icon name="person"></ion-icon></span>
                <input type="text" placeholder="Username" name="uname"  required>
            </div>

            <div class="input-box">
                <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                <input type="password" placeholder="Password" name="password" required>
            </div>
            <div class="input-box">
                <span class="icon"><ion-icon name="mail"></ion-icon></span>
                <input type="mail" placeholder="Mail" name="mail"  required>
            </div>
            <div class="input-box">
                <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                <input type="password" placeholder="Re-enter password" name="re_password"  required>
            </div>
            <!-- <div class="forget-pass">
                <a href="#">Forget Password</a>
            </div> -->
            <button type="submit" class="btn">SignUp</button>
            <div class="register-link">
                <p>Do You already have an account? <a href="login.php">Login</a></p>
            </div>
        </form>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
