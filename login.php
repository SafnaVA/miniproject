<?php
//require_once("connect.php");

session_start();
$con = new mysqli("localhost", "root", "", "event");
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

if (isset($_POST['login'])) {
    $usr = $_POST["username"];
    $psswd = $_POST["password"];

    // Update the SQL query to check for 'blocked' status
    $sql = "SELECT * FROM `signup` WHERE username = '$usr' AND `password` = '$psswd'";
    $res = $con->query($sql);

    if ($res->num_rows > 0) {
        // User found, now check if the user is blocked
        $data = mysqli_fetch_array($res);
        
        if ($data['action'] == 'blocked') {
            // If the user is blocked, redirect back with a 'blocked' error
            header("Location: login.php?error=blocked");
            exit();
        } else {
            // If the user is not blocked, continue with the login process
            $_SESSION['userid'] = $data['userid']; // Store user ID in session
            header("Location: booking.php");
            exit();
        }
    } else {
        // Invalid credentials
        header("Location: login.php?error=invalid");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <header>
        <nav>
            <h1>Event Management System</h1>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="#admin">Admin</a></li>
                <li><a href="#aboutus">About Us</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <div class="login-container">
            <form action="" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit" name="login">Login</button><br>
                <p>Don't have an account? Please <br> <a href="signup.php">Signup</a></p>

                <?php
                    // Check if there's an error from the URL (error=blocked or error=invalid)
                    if (isset($_GET['error'])) {
                        if ($_GET['error'] == 'blocked') {
                            echo '<p style="color: red;">Your account is blocked by the admin.</p>';
                        } elseif ($_GET['error'] == 'invalid') {
                            echo '<p style="color: red;">Invalid username or password.</p>';
                        }
                    }
                ?>
            </form>
        </div>
    </main>
    
    <!-- Footer -->
    <div id="footer">
        <div id="mainfooter1">
            <div id="foot1">
                <h3></h3>
                ADDRESS<br><br>
                Perumbavoor 683547 <br><br>
                Ernakulam <br><br>
                Kerala <br><br>
            </div>
            <div id="foot2">
                <h3>SERVICE</h3><br>
                feedback<br><br>
                aslamva6@gmail.com<br><br>
            </div>
            <div id="foot3">
                <h3>Follow Us:</h3><br>
                <a href="https://your-social-media-link.com">
                    <img src="http://localhost/myproject/images/request-social-media.png" alt="Social Media Icon" style="width: 100px; height: auto;">
                </a>
            </div>
        </div>
        <div id="mainfooter2">
            <div id="footer2">
                &copy; FESTIVE DESIGNERS
            </div>
        </div>
    </div>
</body>
</html>
