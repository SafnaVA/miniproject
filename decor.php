<?php
 SESSION_START();
 $userid = $_SESSION['userid'];
 $event_id=$_SESSION['event_id'];
 $con = new mysqli("localhost", "root", "", "event");
 
 if ($con->connect_error) {
 
  die("Connection failed: " . $con->connect_error);
 }
 if (isset($_POST['submit'])) {
    if(isset($_FILES['theme']['name']))
    {
    $themeImage = $_FILES['theme']['name'];
    }
    else{
        $themeImage=' ';
    }

  $decor = isset($_POST['decoration_items'])? implode(',',$_POST['decoration_items']):'';
  $enter = isset($_POST['entertain'])? implode(',',$_POST['entertain']):'';
  $plate= isset($_POST['plates'])? implode(',',$_POST['plates']):''; 
  $food = $_POST['food_type'];
  $addi= $_POST['additional'];
  $count = $_POST['guest_count'];

  $insertQuery="INSERT INTO `decor`( `userid`, `event_id`, `theme`, `decor`, `entertain`, `catering`, `food_type`, `additional_req`, `guest_count`) VALUES
   ('$userid','$event_id','$themeImage','$decor','$enter','$plate','$food','$addi','$count')";
   if ($con->query($insertQuery) === TRUE) {
     //echo"one row inserted";
     //Registration successful, redirect to the event booking page
     //$redirectUrl = "$event.php";
  //$sql = "SELECT * FROM `decor` WHERE userid = $userid order by event_id desc LIMIT 1";
 // $sql = "SELECT * FROM `decor` WHERE event_id=$event_id order by decor_id desc LIMIT 1";
  // $data = mysqli_query($con,$sql);
 // $row = mysqli_fetch_array($data);
   //  $decor_id = $row['decor_id'];
   //  $_SESSION['decor_id'] = $decor_id;
   // echo"one row inserted";
   header("Location: show decor.php");
  exit; // Terminate the current script
  } else {
  echo "Error: " . $insertQuery . "<br>" . $con->error;
  }
 }
  // Close the database connection
  $con->close();
 ?>

<html>
<head>
    <title>Event Decoration</title>
    <style>
                .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: ;
            border-radius: 8px;
            background-color: ;
        
        }
        .navbar {
            background-color: black; /* Green background */
            padding: 10px;
            display: flex;
            justify-content: space-between; /* Space between links */
            position: relative;
        }

        .navbar a {
            color: white; /* White text color */
            text-decoration: none; /* Remove underline */
            padding: 10px;
            margin: 0 5px;
        }

        .navbar a:hover {
            background-color: black; /* Darker green on hover */
            border-radius: 5px; /* Rounded corners */
        }

        .gallery {
    display: flex;
    flex-wrap: wrap;
    justify-content: left;
}
.gallery-item {
    margin: 1em;
    text-align: left;
}
.gallery-item img {
    width: 400px;
    height: 350px;
    border-radius: 6px;
}
.gallery-item p {
    margin-top: 0.8em;
}
        .theme-upload {
            margin-bottom: 20px;
        }

        .continue-button {
    padding: 10px 15px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
 }

.continue-button:hover {
    background-color: #218838;
 }
 h1
 {
    text-align:center;
 }

    </style>
</head>
<body>
        <!-- Navigation Bar -->
        <div class="navbar">
        <div>
            <a href="view_booking_status.php">View Booking Status</a>
           
            <a href="feedback.php">Add Feedback</a>
            <a href="confirmandcancel.php">Confirm/Cancel booking</a>

        </div>
        <div>
            <a href="logout.php">Logout</a>
        </div>
    </div>
<form action="" method="POST" enctype="multipart/form-data">

    <div class="container">
        <h1>Tell Us How You Want to Be?</h1>
        
        <div class="theme-upload">
            <label for="image">Upload a Theme Image:</label>
            <input type="file" name="theme"id="theme" accept=".jpg,.jpeg,.png" value="">
            <img id="theme-preview" style="display:none; max-width: 100%; margin-top: 10px;">

            <script>
              document.getElementById('theme').onchange = function(event) {
              const file = event.target.files[0];
             const preview = document.getElementById('theme-preview');
             if (file) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
             } else {
                preview.style.display = 'none';
             }
             };
         
             </script>
        </div>
        <div class="gallery">
           <div class="gallery-item">
              <h2><u>Decoration Items</u></h2>
              <label>
              <img src="flowers.avif" alt="Flowers" class="form-group img">
              <p> <input type="checkbox" name="decoration_items[]" value="Flowers"> Flowers</p></label><br>
              <label>
              <img src="light.webp" alt="lights" class="form-group img">
              <p><input type="checkbox" name="decoration_items[]" value="Bulbs"> Bulbs</p></label><br><br>
            </div>
            <div class="gallery-item">
              <label>
              <img src="counter.jpg" alt="counters" class="form-group img">
              <p><input type="checkbox" name="decoration_items[]" value="Counters"> Counters</p></label><br><br>
              <label>
              <img src="table.webp" alt="table settings" class="form-group img">
              <p><input type="checkbox" name="decoration_items[]" value="Table Settings"> Table Settings</p></label><br><br>
             </div>
             <div class="gallery-item">
              <label>
                <img src="chaircover.jpg"alt="chair cover" class="form-group img">
                <p><input type="checkbox" name="decoration_items[]" value="Chair Covers"> ChairCovers</p></label><br><br>
            </div>

            <div class="gallery-item">
              <h2><u>Entertainment</u></h2>
              <label>
                <img src="music.jpg" alt="music band">
              <p><input type="checkbox" name="entertain[]" value="Music Band"> Music Band</p></label><br>

              <label>
                <img src="dance.webp" alt="dance">
                <p><input type="checkbox" name="entertain[]" value="Dance Performance"> Dance Performance</p></label><br>
             </div>
            <div class="gallery-item">
                <label>
                    <img src="oppana.jpg"alt="oppana">
                <p><input type="checkbox" name="entertain[]" value="oppana"> oppana</p></label><br>
                <label>
                    <img src="kolkali.jpg"alt="kolkali">
                <p><input type="checkbox" name="entertain[]" value="kolkali"> kolkali</p></label><br>
            </div>
             <div class="gallery-item">

                <label>
                    <img src="dj.jpg"alt="dj">
                <p><input type="checkbox" name="entertain[]" value="dj"> DJ</p></label><br>
                <label>
                <img src="karoke.jpg"alt="karoke">
                <p><input type="checkbox" name="entertain[]" value="karoke">karoke</p></label><br>
    </div>
                
           <div class="gallery-item">
             <h2><u>Food and Catering Requirements</u></h2><br>
             <label>
             <img src="plate.jpg"alt="plate">
                <p><input type="checkbox" name="plates[]" value="Plate"> Plates</p></label>
              <label>
                <img src="chefndish.avif" alt="chef and dish">
                <p><input type="checkbox" name="plates[]" value="Chef and Dish">chef and dish</p></label>
              <label>
            </div>
            <div class="gallery-item">
                <img src="ovaldish.jpg"alt="ovaldish">
                <p><input type="checkbox" name="plates[]" value="Oval Dish"> Oval Dish</p></label><br>
               <label>
                <img src="bowl.webp" alt="bowls">
                <p><input type="checkbox" name="plates[]" value="Bowls"> Bowls</p></label><br>
                <label>
            
            
                <img src="glass.webp" alt="glasses">
                <p><input type="checkbox" name="plates[]" value="glasses"> glasses</p></label>
            </div>
        </div>
    </div>
    <div class="form-group">
    <h1>Food Type:</h1>
               <select name="food_type">
                <option value="veg">Veg</option>
                <option value="non-veg">Non-Veg</option>
                <option value="both">Both</option>
               </select>
    </div>
        <div class="form-group">
            <h1>Additional Requirements:</h1><br>
            <textarea id="additional_requirements" name="additional" rows="2" ></textarea>
        </div>

        <div class="form-group">
            <label for="guest_count"><h1>Number of Guests:</h1></label><br><br>
            <input type="number" id="guest_count" name="guest_count" required><br><br>
        </div>

        <button type="submit" class="continue-button" name="submit">Continue Booking</button><br>
</form>
</body>
</html>