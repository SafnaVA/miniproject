<?php
//require_once("connect.php");
$con = new mysqli("localhost", "root", "", "event");
if ($con->connect_error) {
 die("Connection failed: " . $con->connect_error);
}
if(isset($_POST['login'])){
 $usr=$_POST['username'];
 $pass=$_POST['password'];
 $sql="SELECT * FROM admin_login where admin_name='$usr' and password='$pass' ";
 $data=mysqli_query($con,$sql);
 $row=mysqli_num_rows($data);
 if($row>0){
 echo "<script type='text/javascript'> window.top.location='admin_dashboard.php';</script>";
 exit();
 }
 else{
 echo "<script type='text/javascript'>alert('Wrong password or username');</script>";
 }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Document</title>
 <style>
 * {
 margin: 0px;
 padding: 0px;
 }
 #nav1 {
 width: 50%;
 color: white;
 display: flex;
 /* justify-content: start; */
 gap: 50px;
 padding-left: 50px;
 font-size:x-large;
 }
 #nav1::first-letter {
 color: rgb(255, 0, 0);
 }
 #navbar {
 width: 100%;
 position: fixed;
 display: flex;
 padding: 30px;
 background-color: rgb(16, 16, 16);
 }
 .nav-link {
 color: rgb(255, 255, 255);
 text-decoration: none;
 font-size: larger;
 font-weight: 900;

 font-family: monospace;
 text-transform: capitalize;
 }
 .nav-link:hover {
 color: rgb(173, 223, 198);
 }
 #footer {
 padding: 30px;
 color: rgb(7, 162, 74);
 padding-left: 50px;
 background-color: lightgray;
 }
 #mainfooter1 {
 display: flex;
 }
 #footer2 {
 text-align: center;
 font-family: monospace;
 letter-spacing: 5px;
 font-weight: bold;
 font-size: 16px;
 color: white;
 background-color:black ;
 }
 #nav2 {
 display: flex;
 width: 50%;
 justify-content: space-around;
 }
 #hero {
74
 width: 100%;
 /* min-height: 100%; */
 /* height: 100vh; */
 color: black;
 text-align: center;
 display: flex;
 justify-content: center;
 background-image: url('http://localhost/myproject/images/admin_background.webp');
 background-size: cover;
 /* background-repeat: no-repeat; */
 /* background-position: center center; */
}
 #about {
 text-align: center;
 display: flex;
 width: 80%;
 justify-content: space-around;
 background-color: rgb(255, 255, 255);
 font-size: larger;
 }
 #hero_content {
 text-align: center;
 font-style: calc();
 font-size: 50px;
 color: rgb(17, 17, 17);
 }

#caption {
 background-color:white;
 padding: 20px;
 text-align: center;
}
.inp{
    padding: 3px;
 border-radius: 5px;
 font-family: cursive;
 /* color: black; */
 }
 td{
 padding: 5px;
 }
 form {
 background-color: rgba(255, 255, 255, 0.8); /* Form background with transparency */
 padding: 20px;
 margin: 20px auto;
 max-width: 400px;
 border-radius: 10px;
 box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
 }
#foot1 {
 color: rgb(10, 10, 10);
 text-transform: capitalize;
 font-weight: bold;
 padding-left: 50px;
 width: 70%;
 }
 #foot2 {
 color: rgb(12, 12, 12);
 width: 50%;
 font-weight: bold;
 }
 #foot3 {
 color: rgb(12, 12, 12);
 text-transform: capitalize;
 font-weight: bold;
 text-align: center;
 width: 50%;
}
 #mainfooter2 {
 background-color: rgb(17, 210, 143);
 }
/* Add this CSS for the login button */
.login-button {
 background-color: #007bff; /* Your preferred background color */
 color: #fff;
 padding: 10px 20px;
 border: none;
 border-radius: 5px;
 font-weight: bold;
 font-size: 16px;
 cursor: pointer;
 transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s; /* Add smooth transitions */
}
/* Hover effect */
.login-button:hover {
 background-color: #0056b3; /* New color on hover */
 box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Add a subtle shadow on hover */
 transform: scale(1.05); /* Scale the button slightly on hover */
}
 </style>
</head>
<body>
 <!-- Navbar opening-->
 <div id="navbar">
 <div id="nav1"> EVENT MANAGEMENT SYSTEM
 </div>
 <div id="nav2">
 <a href="homepage.php" class="nav-link">HOME</a>
 <a href="login.php" class="nav-link">LOGIN</a>
 <a href="admin.php" class="nav-link">ADMIN</a>
 <a href="about.php" class="nav-link">ABOUT US</a>
 </div>
 </div>
 <!-- Navbar closing-->
 <!-- hero section opening -->
 <div id="hero">
 <div style="display: flex;justify-content: center; padding: 240px;">
 <div style="width: 100%;">
 <h1 id="hero_head">lOGIN</h1><br><br>
 <p id="hero_content">
 <form class="form" action="admin.php" method="post">
 <table>
 <tr>
 <th>USERNAME </th>
 <td> <input type="text" name="username" id="" class="inp"
required><br><br></td>
 </tr>
 <tr>
 <th>PASSWORD </th>
 <td> <input type="password" name="password" id="" class="inp" required></td>
 </tr>
 <tr>
 <td></td>
 </tr>
 <td><button class="hero_bt login-button" type="submit"
name="login">Login</button></td>
 </form>
 </table>
 </p>
 </div>
 </div>
 </div>
 <!-- hero section closing -->
 <!-- footer opening -->
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
 <!-- footer closing -->
</body>
</html>