<?php
session_start(); // Start the session
if (isset($_POST['submit'])) {
    $nm = $_POST['username'];
    $eml = $_POST['email'];
    $adrs = $_POST['address'];
    $phn = $_POST['phone'];
    $pswrd = $_POST['password'];


    // Database connection
    $dbcon = mysqli_connect("localhost", "root", "", "event");

    // Check connection
    if (!$dbcon) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO `signup`(`username`, `email`, `address`, `phoneno`, `password`) VALUES ('$nm','$eml','$adrs','$phn','$pswrd')";
    $data = mysqli_query($dbcon, $sql);

    if ($data) {
       // echo"one record added";
        // Store user information in session variables
       // $_SESSION['username'] = $nm;
       // $_SESSION['email'] = $eml;
        //$res = $dbcon->query($sql);
       //$data = mysqli_fetch_array($res);
//$_SESSION['userid'] = $data['userid'];
        // Redirect to a welcome page or dashboard
    } else {
        echo "Error: " . mysqli_error($dbcon);
    }

    mysqli_close($dbcon);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
<header>
    <nav>
        <h3>Event Management System</h3>
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
    <form class="signup-form" action="" method="POST">
        <h2>Create Your Account</h2>
        
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="email">Email ID:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required>
        
        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" required pattern="\d{10}" title="Phone number must be exactly 10 digits "required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit" name="submit">Sign Up</button>
    </form>
</main>
<!-- Footer -->
<div id="footer">
 <div id="mainfooter1">
 <div id="foot1">
 <h3></h3>
 ADDRESS<br><br>
 Perumbavoor 683547 <br><br>
 Ernakulam <br><br>
 kerala <br><br>
 </div>
 <div id="foot2">
 <h3>SERVICE</h3><br>
 feedback<br><br>
 aslamva6@gmail.com<br><br>
 </div>
 <div id="foot3">
 <h3>Follow Us:</h3><br>
 <a href="https://your-social-media-link.com">
 <img src="http://localhost/myproject/images/request-social-media.png" alt="Social Media
Icon" style="width: 100px; height: auto;">
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

</body>
</html>
