<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "event");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the necessary POST variables are set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id']) && isset($_POST['status'])) {
    $event_id = intval($_POST['event_id']);
    $status = $_POST['status'];
    $reason = isset($_POST['reason']) ? $_POST['reason'] : null;

    if ($status === 'Rejected' && $reason) {
        // Update booking status to 'Rejected' with reason
        $stmt = $conn->prepare("UPDATE booking SET status = ?, rejection_reason = ? WHERE event_id = ?");
        $stmt->bind_param("ssi", $status, $reason, $event_id);
    } else {
        // Update booking status to 'Accepted'
        $stmt = $conn->prepare("UPDATE booking SET status = ? WHERE event_id = ?");
        $stmt->bind_param("si", $status, $event_id);
    }

    if ($stmt->execute()) {
        // Status updated successfully
    } else {
        // Handle error
    }

    $stmt->close();
}

// Fetch data from the booking table
$sql = "SELECT b.event_id, b.userid, b.event_name, b.full_name, b.location, b.event_date_from, b.event_date_to, b.start_time, b.end_time, b.status 
        FROM booking b
        JOIN signup s ON b.userid = s.userid
        WHERE s.action != 'blocked' OR s.action IS NULL";
$result = $conn->query($sql);

// Create an array to store bookings grouped by event_name
$groupedBookings = [];

if ($result->num_rows > 0) {
    // Group bookings by event_name
    while ($row = $result->fetch_assoc()) {
        $eventName = $row['event_name'];
        if (!isset($groupedBookings[$eventName])) {
            $groupedBookings[$eventName] = [];
        }
        $groupedBookings[$eventName][] = $row;
    }
} else {
    echo "<tr><td colspan='10'>No bookings found</td></tr>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Booking Management</title>
    <link rel="stylesheet" href="view_booking.css"> <!-- Link to your CSS file -->
</head>
<body>
    <header>
        <nav>
            <div class="nav-container">
                <h1>Welcome Admin</h1>
                <a href="logout.html" class="logout">Logout</a>
            </div>
        </nav>
    </header>

    <div class="container">
        <aside class="sidebar">
            <ul class="sidebar-links">
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="view user.php">View Users</a></li>
                <li><a href="view_booking.php">View Bookings</a></li>
                <li><a href="manage_booking.php">Manage Bookings</a></li>
                <li><a href="view_feedback.php">View Feedback</a></li>
                <li><a href="manage_cancel.php">View cancels</a></li>
                <li><a href="manage_confirm.php">View confirmed bookings</a></li>
            </ul>
        </aside>

        <main>
            <?php
            // Loop through each event group
            foreach ($groupedBookings as $eventName => $bookings) {
                echo "<h2>{$eventName} Bookings</h2>";
                echo "<table>
                    <thead>
                        <tr>
                            <th>Event ID</th>
                            <th>User ID</th>
                            <th>Event Name</th>
                            <th>Full Name</th>
                            <th>Location</th>
                            <th>Event Date From</th>
                            <th>Event Date To</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>";

                // Loop through each booking under this event group
                foreach ($bookings as $row) {
                    echo "<tr>
                        <td>{$row['event_id']}</td>
                        <td>{$row['userid']}</td>
                        <td>{$row['event_name']}</td>
                        <td>{$row['full_name']}</td>
                        <td>{$row['location']}</td>
                        <td>{$row['event_date_from']}</td>
                        <td>{$row['event_date_to']}</td>
                        <td>{$row['start_time']}</td>
                        <td>{$row['end_time']}</td>
                        <td>{$row['status']}</td>
                        <td>
                            <form method='POST' style='display:inline;'>
                                <input type='hidden' name='event_id' value='{$row['event_id']}'>
                                <input type='hidden' name='status' value='Accepted'>
                                <button type='submit'>Accept</button>
                            </form>
                            <form method='POST' style='display:inline;'>
                                <input type='hidden' name='event_id' value='{$row['event_id']}'>
                                <input type='hidden' name='status' value='Rejected'>
                                <textarea name='reason' placeholder='Reason' required></textarea>
                                <button type='submit'>Reject</button>
                            </form>
                        </td>
                    </tr>";
                }

                echo "</tbody></table>";
            }
            ?>
        </main>
    </div>
</body>
</html>
