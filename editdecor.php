<?php
// Start session to retrieve user session data
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

$userid = $_SESSION['userid'];

// Retrieve event_id from URL
if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];
} else {
    // Redirect if event_id is not provided
    header("Location: event_selection.php");
    exit;
}

$con = new mysqli("localhost", "root", "", "event");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch the decoration data for the selected event
$sql = "SELECT * FROM decor WHERE userid = '$userid' AND event_id = '$event_id' LIMIT 1";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Fetch the stored data
    $themeImage = $row['theme'];
    $decor = explode(',', $row['decor']);
    $entertain = explode(',', $row['entertain']);
    $plates = explode(',', $row['catering']);
    $food_type = $row['food_type'];
    $additional = $row['additional_req'];
    $guest_count = $row['guest_count'];
} else {
    // Redirect if no decoration data is found for the selected event
    header("Location: event_selection.php");
    exit;
}

// Handle form submission for updating decoration data
if (isset($_POST['submit'])) {
    $themeImage = $_FILES['theme']['name'] ? $_FILES['theme']['name'] : $themeImage;
    $decor = isset($_POST['decoration_items']) ? implode(',', $_POST['decoration_items']) : '';
    $entertain = isset($_POST['entertain']) ? implode(',', $_POST['entertain']) : '';
    $plates = isset($_POST['plates']) ? implode(',', $_POST['plates']) : '';
    $food_type = $_POST['food_type'];
    $additional = $_POST['additional'];
    $guest_count = $_POST['guest_count'];

    // Update decoration data in the database
    $updateQuery = "UPDATE decor SET
                    theme = '$themeImage',
                    decor = '$decor',
                    entertain = '$entertain',
                    catering = '$plates',
                    food_type = '$food_type',
                    additional_req = '$additional',
                    guest_count = '$guest_count'
                    WHERE userid = '$userid' AND event_id = '$event_id'";

    if ($con->query($updateQuery) === TRUE) {
        // Redirect after successful update
        header("Location: show decor.php");
        exit;
    } else {
        echo "Error updating record: " . $con->error;
    }
}

$con->close();
?>



<html>
<head>
    <title>Edit Event Decoration</title>
    <style>
        /* Style similar to your original page */
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border-radius: 8px;
            background-color: #f4f4f4;
        }

        .navbar {
            background-color: black;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            position: relative;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            margin: 0 5px;
        }

        .navbar a:hover {
            background-color: #444;
            border-radius: 5px;
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

        h1 {
            text-align: center;
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

    <!-- Edit Decoration Form -->
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="container">
            <h1>Edit Your Event Decoration</h1>

            <!-- Theme Upload -->
            <div class="theme-upload">
                <label for="image">Upload a New Theme Image:</label>
                <input type="file" name="theme" id="theme" accept=".jpg,.jpeg,.png">
                <img id="theme-preview" style="display:none; max-width: 100%; margin-top: 10px;" src="<?php echo $themeImage; ?>">

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

            <!-- Decoration Items -->
            <div class="gallery">
                <div class="gallery-item">
                    <h2><u>Decoration Items</u></h2>
                    <label><img src="flowers.avif" alt="Flowers">
                        <input type="checkbox" name="decoration_items[]" value="Flowers" <?php echo in_array('Flowers', $decor) ? 'checked' : ''; ?>> Flowers</label><br>
                    <label><img src="light.webp" alt="Lights">
                        <input type="checkbox" name="decoration_items[]" value="Bulbs" <?php echo in_array('Bulbs', $decor) ? 'checked' : ''; ?>> Bulbs</label><br>
                    <label><img src="counter.jpg" alt="Counters">
                        <input type="checkbox" name="decoration_items[]" value="Counters" <?php echo in_array('Counters', $decor) ? 'checked' : ''; ?>> Counters</label><br>
                    <label><img src="table.webp" alt="Table Settings">
                        <input type="checkbox" name="decoration_items[]" value="Table Settings" <?php echo in_array('Table Settings', $decor) ? 'checked' : ''; ?>> Table Settings</label><br>
                    <label><img src="chaircover.jpg" alt="Chair Covers">
                        <input type="checkbox" name="decoration_items[]" value="Chair Covers" <?php echo in_array('Chair Covers', $decor) ? 'checked' : ''; ?>> Chair Covers</label><br>
                </div>

                <!-- Entertainment -->
                <div class="gallery-item">
                    <h2><u>Entertainment</u></h2>
                    <label><img src="music.jpg" alt="Music Band">
                        <input type="checkbox" name="entertain[]" value="Music Band" <?php echo in_array('Music Band', $entertain) ? 'checked' : ''; ?>> Music Band</label><br>
                    <label><img src="dance.webp" alt="Dance Performance">
                        <input type="checkbox" name="entertain[]" value="Dance Performance" <?php echo in_array('Dance Performance', $entertain) ? 'checked' : ''; ?>> Dance Performance</label><br>
                    <label><img src="oppana.jpg" alt="oppana">
                        <input type="checkbox" name="entertain[]" value="oppana" <?php echo in_array('oppana', $entertain) ? 'checked' : ''; ?>> oppana</label><br>
                        <label><img src="kolkali.jpg" alt="kolkali">
                        <input type="checkbox" name="entertain[]" value="kolkali" <?php echo in_array('kolkali', $entertain) ? 'checked' : ''; ?>> kolkali</label><br>
                        <label><img src="dj.jpg" alt="DJ">
                        <input type="checkbox" name="entertain[]" value="dj" <?php echo in_array('dj', $entertain) ? 'checked' : ''; ?>> dj</label><br>
                        <label><img src="karoke.jpg" alt="karoke">
                        <input type="checkbox" name="entertain[]" value="karoke" <?php echo in_array('karoke', $entertain) ? 'checked' : ''; ?>> karoke</label><br>
                </div>

                <!-- Catering -->
                <div class="gallery-item">
                    <h2><u>Catering Items</u></h2>
                    <label><img src="plate.jpg" alt="Plates">
                        <input type="checkbox" name="plates[]" value="Plate" <?php echo in_array('Plate', $plates) ? 'checked' : ''; ?>> Plates</label><br>
                    <label><img src="chefndish.avif" alt="Chef and Dish">
                        <input type="checkbox" name="plates[]" value="Chef and Dish" <?php echo in_array('Chef and Dish', $plates) ? 'checked' : ''; ?>> Chef and Dish</label><br>
                        <label><img src="ovaldish.jpg" alt="ovaldish">
                        <input type="checkbox" name="plates[]" value="Oval Dish" <?php echo in_array('Oval Dish', $plates) ? 'checked' : ''; ?>> Oval Dish</label><br>
                        <label><img src="bowl.webp" alt="bowls">
                        <input type="checkbox" name="plates[]" value="Bowls" <?php echo in_array('Bowls', $plates) ? 'checked' : ''; ?>>Bowls</label><br>
                        <label><img src="glass.webp" alt="Glasses">
                        <input type="checkbox" name="plates[]" value="glasses" <?php echo in_array('glasses', $plates) ? 'checked' : ''; ?>> glasses</label><br>
                </div>
            </div>

            <!-- Food Type -->
            <div class="form-group">
                <h1>Food Type:</h1>
                <select name="food_type">
                    <option value="veg" <?php echo ($food_type == 'veg') ? 'selected' : ''; ?>>Veg</option>
                    <option value="non-veg" <?php echo ($food_type == 'non-veg') ? 'selected' : ''; ?>>Non-Veg</option>
                    <option value="both" <?php echo ($food_type == 'both') ? 'selected' : ''; ?>>Both</option>
                </select>
            </div>

            <!-- Additional Requirements -->
            <div class="form-group">
                <h1>Additional Requirements:</h1>
                <textarea name="additional" rows="2"><?php echo $additional; ?></textarea>
            </div>

            <!-- Guest Count -->
            <div class="form-group">
                <label for="guest_count"><h1>Number of Guests:</h1></label>
                <input type="number" id="guest_count" name="guest_count" value="<?php echo $guest_count; ?>" required><br>
            </div>

            <button type="submit" class="continue-button" name="submit">Update Booking</button>
        </div>
    </form>
</body>
</html>
