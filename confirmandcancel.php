<?php
session_start();
$con = new mysqli("localhost", "root", "", "event");

// Check the connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch the user id from session
$userid = $_SESSION['userid'];

// Query to fetch all of the user's booking information (whether cancelled or not)
$sql = "SELECT * FROM `booking` WHERE `userid` = '$userid'";
$result = $con->query($sql);

// Handle confirm booking action
if (isset($_POST['confirm_booking'])) {
    $event_id = $_POST['event_id'];

    // Check if the total_cost has been updated in the decor table
    $decorQuery = "SELECT total_cost FROM `decor` WHERE `event_id` = $event_id";
    $decorResult = $con->query($decorQuery);
    
    if ($decorResult->num_rows > 0) {
        $decor = $decorResult->fetch_assoc();
        if ($decor['total_cost'] > 0) {
            // Proceed with booking confirmation
            $updateQuery = "UPDATE `booking` SET `is_cancelled` = 2 WHERE `event_id` = $event_id";
            if ($con->query($updateQuery) === TRUE) {
                $message = "Booking confirmed successfully.";
            } else {
                $message = "Error: " . $con->error;
            }
        } else {
            // Inform the user to wait for the cost to be updated
            $message = "Booking cannot be confirmed until the admin updates the total cost.";
        }
    } else {
        $message = "Error: Decor information not found.";
    }
}

// Handle cancel booking action
if (isset($_POST['cancel_booking'])) {
    $event_id = $_POST['event_id'];
    $updateQuery = "UPDATE `booking` SET `is_cancelled` = 0 WHERE `event_id` = $event_id";
    if ($con->query($updateQuery) === TRUE) {
        $message = "Booking canceled successfully.";
    } else {
        $message = "Error: " . $con->error;
    }
}

$con->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Your Bookings</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    /* General page styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

.navbar {
    background-color: #333;
    padding: 10px;
}

.navbar a {
    color: white;
    padding: 10px;
    text-decoration: none;
    margin-right: 10px;
}

.navbar a:hover {
    background-color: #575757;
}

.container {
    margin: 20px;
}

.header h1 {
    font-size: 24px;
    margin-bottom: 20px;
}

.message {
    padding: 10px;
    margin-bottom: 20px;
    background-color: #e8f7e7;
    color: #2d7f3f;
    border-radius: 5px;
}

.booking-details {
    margin: 20px 0;
}

.booking-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

.booking-table th, .booking-table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

.booking-table th {
    background-color: #f2f2f2;
}

button {
    padding: 8px 16px;
    border: none;
    cursor: pointer;
}

.btn-confirm {
    background-color: #4CAF50;
    color: white;
}

.btn-cancel {
    background-color: #f44336;
    color: white;
}

button:hover {
    opacity: 0.8;
}

.status-confirmed {
    color: green;
    font-weight: bold;
}

.status-canceled {
    color: red;
    font-weight: bold;
}
</style>
<body>

    <!-- Navigation Bar -->
    <header class="navbar">
        <nav>
            <a href="view_booking_status.php">View Booking Status</a>
            
            <a href="feedback.php">Add Feedback</a>
            <a href="confirmandcancel.php">Confirm/Cancel Booking</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main class="container">
        <div class="header">
            <h1>Your Bookings</h1>
        </div>

        <!-- Display success or error message -->
        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Displaying all bookings for the user -->
        <section class="booking-details">
            <?php if ($result->num_rows > 0): ?>
                <table class="booking-table">
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Full Name</th>
                            <th>Location</th>
                            <th>Event Date From</th>
                            <th>Event Date To</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($booking = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($booking['event_name']); ?></td>
                                <td><?php echo htmlspecialchars($booking['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($booking['location']); ?></td>
                                <td><?php echo htmlspecialchars($booking['event_date_from']); ?></td>
                                <td><?php echo htmlspecialchars($booking['event_date_to']); ?></td>
                                <td><?php echo htmlspecialchars($booking['start_time']); ?></td>
                                <td><?php echo htmlspecialchars($booking['end_time']); ?></td>
                                <td>
                                    <?php if ($booking['is_cancelled'] == 1): ?>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="event_id" value="<?php echo $booking['event_id']; ?>">
                                            <button type="submit" name="confirm_booking" class="btn-confirm">Confirm</button>
                                        </form>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="event_id" value="<?php echo $booking['event_id']; ?>">
                                            <button type="submit" name="cancel_booking" class="btn-cancel">Cancel</button>
                                        </form>
                                    <?php elseif ($booking['is_cancelled'] == 2): ?>
                                        <span class="status-confirmed">Booking Confirmed</span>
                                    <?php elseif ($booking['is_cancelled'] == 0): ?>
                                        <span class="status-canceled">Booking Canceled</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>You have no bookings.</p>
            <?php endif; ?>
        </section>
    </main>

</body>
</html>
