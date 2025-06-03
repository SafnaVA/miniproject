<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['userid'])) {
    echo "User not logged in!";
    exit;
}

$userid = $_SESSION['userid'];
$dbcon = mysqli_connect("localhost", "root", "", "event");

// Check if booking ID is provided in the URL
if (isset($_GET['id'])) {
    $bookingId = $_GET['id'];

    // Fetch the current booking details from the database
    $stmt = $dbcon->prepare("SELECT * FROM booking WHERE event_id = ? AND userid = ?");
    $stmt->bind_param("ii", $bookingId, $userid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $booking = $result->fetch_assoc();
    } else {
        echo "No booking found!";
        exit;
    }
} else {
    echo "No booking ID provided!";
    exit;
}

// Handle form submission to update booking
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $event_name = $_POST['event_name'];
    $full_name = $_POST['full_name'];
    $location = $_POST['location'];
    $date_from = $_POST['event_date_from'];
    $date_to = $_POST['event_date_to'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Update the booking information in the database
    $updateStmt = $dbcon->prepare("UPDATE booking SET event_name = ?, full_name = ?, location = ?, event_date_from = ?, event_date_to = ?, start_time = ?, end_time = ? WHERE event_id = ?");
    $updateStmt->bind_param("sssssssi", $event_name, $full_name, $location, $date_from, $date_to, $start_time, $end_time, $bookingId);

    if ($updateStmt->execute()) {
        $success_message = "Booking updated successfully!";

        // Redirect to show_decor.php after successful update
        header('Location: show decor.php');
        exit(); // Stop further script execution to ensure redirect happens
    } else {
        $error_message = "Error updating booking!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Booking</title>
    <link rel="stylesheet" href="booking.css">
</head>
<body>
    <h1>Edit Your Booking</h1>
    
    <!-- Display Success or Error Message -->
    <?php if (isset($success_message)) { ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php } elseif (isset($error_message)) { ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php } ?>

    <div class="booking-form">
        <!-- Wrap the entire form correctly -->
        <form id="eventBookingForm" action="" method="POST">
            <div class="form-group">
                <label for="event_name">Event Name</label>
                <select id="event_name" name="event_name" required>
                    <option value="Wedding" <?php echo ($booking['event_name'] == 'Wedding') ? 'selected' : ''; ?>>Wedding</option>
                    <option value="Birthday" <?php echo ($booking['event_name'] == 'Birthday') ? 'selected' : ''; ?>>Birthday</option>
                    <option value="Engagement" <?php echo ($booking['event_name'] == 'Engagement') ? 'selected' : ''; ?>>Engagement</option>
                    <option value="Bridal Shower" <?php echo ($booking['event_name'] == 'Bridal Shower') ? 'selected' : ''; ?>>Bridal Shower</option>
                    <option value="Baby Shower" <?php echo ($booking['event_name'] == 'Baby Shower') ? 'selected' : ''; ?>>Baby Shower</option>
                </select>
            </div>

            <div class="form-group">
                <label for="full_name">Your Full Name</label>
                <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($booking['full_name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="location">Location of Event</label>
                <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($booking['location']); ?>" required>
            </div>

            <div class="form-group">
                <label for="event_date">Date of Event from:</label>
                <input type="date" id="date_from" name="event_date_from" value="<?php echo htmlspecialchars($booking['event_date_from']); ?>" required>
            </div>
            <div class="form-group">
                <label for="event_date">Date of Event to:</label>
                <input type="date" id="date_to" name="event_date_to" value="<?php echo htmlspecialchars($booking['event_date_to']); ?>" required>
            </div>

            <div class="form-group">
                <label for="start_time">Starting Time</label>
                <input type="text" id="start_time" name="start_time" placeholder="hh:mm am/pm" value="<?php echo htmlspecialchars($booking['start_time']); ?>" required>
            </div>

            <div class="form-group">
                <label for="end_time">Ending Time</label>
                <input type="text" id="end_time" name="end_time" placeholder="hh:mm am/pm" value="<?php echo htmlspecialchars($booking['end_time']); ?>" required>
            </div>

            <!-- Submit button to update the booking -->
           

            <button type="submit" id="submit" name="submit" >Update Booking</button>
        </form>
    </div>
</body>
</html>
