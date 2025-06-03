<?php
session_start();
$con = new mysqli("localhost", "root", "", "event");
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Initialize error variables
$error_message = "";

if (isset($_POST['submit'])) {

    // Get today's date in Y-m-d format
    $today = date("Y-m-d");

    $event = $_POST['event_name'];
    $name = $_POST['full_name'];
    $location = $_POST['location'];
    $date_from = $_POST['event_date_from'];
    $date_to = $_POST['event_date_to'];
    $starttime = $_POST['start_time'];
    $endtime = $_POST['end_time'];
    $userid = $_SESSION['userid'];

    // Validate the dates
    if ($date_from < $today) {
        $error_message = "The start date cannot be before today. Please select a valid start date.";
    } elseif ($date_to < $today) {
        $error_message = "The end date cannot be before today. Please select a valid end date.";
    } elseif ($date_from > $date_to) {
        $error_message = "The start date cannot be later than the end date. Please select a valid date range.";
    }

    // If no error, proceed with database insertion
    if (empty($error_message)) {
        $insertQuery = "INSERT INTO `booking`( `userid`, `event_name`, `full_name`, `location`, `event_date_from`, `event_date_to`, `start_time`, `end_time`) 
                        VALUES ('$userid','$event','$name','$location','$date_from','$date_to','$starttime','$endtime')";
        
        if ($con->query($insertQuery) === TRUE) {
            // Booking successful, get the most recent booking ID
            $sql = "SELECT * FROM `booking` WHERE userid = $userid ORDER BY event_id DESC LIMIT 1";
            $data = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($data);
            $event_id = $row['event_id'];
            $_SESSION['event_id'] = $event_id;
            header("Location: decor.php");
            exit; // Terminate the current script
        } else {
            $error_message = "Error: " . $insertQuery . "<br>" . $con->error;
        }
    }
}

// Close the database connection
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Your Event</title>
    <link rel="stylesheet" href="booking.css">
</head>
<body>
    <!-- Navigation Bar -->
    <div class="navbar">
        <div>
            <a href="view_booking_status.php">View Booking Status</a>
            <a href="feedback.php">Add Feedback</a>
            <a href="confirmandcancel.php">Confirm/Cancel booking</a>
            <a href="show decor.php">Edit Your Booking</a>
        </div>
        <div>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="header">
            <h1>Start Booking Your Event</h1>
        </div>
        <div class="booking-form">
            <form id="eventBookingForm" action="" method="POST">
                <div class="form-group">
                    <label for="event_name">Event Name</label>
                    <select id="event_name" name="event_name" required>
                        <option value="" disabled selected>Select your event</option>
                        <option value="Wedding">Wedding</option>
                        <option value="Birthday">Birthday</option>
                        <option value="Engagement">Engagement</option>
                        <option value="Bridal Shower">Bridal Shower</option>
                        <option value="Baby Shower">Baby Shower</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="full_name">Your Full Name</label>
                    <input type="text" id="full_name" name="full_name" required>
                </div>
                <div class="form-group">
                    <label for="location">Location of Event</label>
                    <input type="text" id="location" name="location" required>
                </div>
                <div class="form-group">
                    <label for="date_from">Date of Event from:</label>
                    <input type="date" id="date_from" name="event_date_from" required>
                </div>
                <div class="form-group">
                    <label for="date_to">Date of Event to:</label>
                    <input type="date" id="date_to" name="event_date_to" required>
                </div>
                <div class="form-group">
                    <label for="start_time">Starting Time</label>
                    <input type="text" id="start_time" name="start_time" placeholder="hh:mm am/pm" required>
                </div>
                <div class="form-group">
                    <label for="end_time">Ending Time</label>
                    <input type="text" id="end_time" name="end_time" placeholder="hh:mm am/pm" required>
                </div>

                <!-- Display error message if any -->
                <?php if ($error_message != ""): ?>
                    <div class="error-message" style="color: red;">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>

                <button type="submit" id="submit" name="submit">Submit Booking</button>
            </form>
        </div>
    </div>

</body>
</html>
