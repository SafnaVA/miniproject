<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "event");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for updating total cost
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $decor_id = $_POST['decor_id'];
    $total_cost = $_POST['total_cost'];

    // Update the total_cost in the decor table
    $sql = "UPDATE decor SET total_cost = ? WHERE decor_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $total_cost, $decor_id); // 'd' for double, 'i' for integer

    if ($stmt->execute()) {
        // Success message can be added here if needed
    } else {
        echo "Error updating total cost: " . $conn->error;
    }

    $stmt->close();
}

// Fetching decor details for users with accepted bookings
$sql = "
    SELECT 
        b.event_id, b.userid, b.full_name,b.event_name, 
        d.decor_id, d.theme, d.decor, d.entertain, 
        d.catering, d.food_type, d.additional_req, 
        d.guest_count, d.total_cost
    FROM 
        booking b
    JOIN 
        decor d ON b.event_id = d.event_id
      JOIN
        signup s ON b.userid = s.userid   -- Join with signup table to check user's status
    WHERE 
        b.status = 'Accepted'  -- Only fetch accepted bookings
        AND (s.action != 'blocked' OR s.action IS NULL)  -- Exclude blocked users
    
";

$result = $conn->query($sql);
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
    <title>Event Management - Accepted Decor Details</title>
    <link rel="stylesheet" href="manage_booking.css"> <!-- Link to your CSS file -->
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
                <li><a href="manage_confirm.php">View Cofirmed bookings</a></li>


            </ul>
        </aside>

        <main>
        <?php
            // Loop through each event group
            foreach ($groupedBookings as $eventName => $bookings) {
                echo "<h2>{$eventName} Bookings</h2>";
           echo" <table>
                <thead>
                    <tr>
                        <th>Event ID</th>
                        <th>User ID</th>
                        <th>Full Name</th>
                        <th>Event name</th>
                        <th>Decor ID</th>
                        <th>Theme</th> <!-- This will show the theme image -->
                        <th>Decor</th>
                        <th>Entertainment</th>
                        <th>Catering</th>
                        <th>Food Type</th>
                        <th>Additional Requirements</th>
                        <th>Guest Count</th>
                        <th>Total Cost</th>
                    </tr>
                </thead>
                <tbody>";
                    // Loop through each booking under this event group
                foreach ($bookings as $row) 
                {
                            echo "<tr>
                                <td>{$row['event_id']}</td>
                                <td>{$row['userid']}</td>
                                <td>{$row['full_name']}</td>
                                <td>{$row['event_name']}</td>
                                <td>{$row['decor_id']}</td>
                                <td>
                                    <img src='{$row['theme']}' style='width: 100px; height: auto;'> <!-- Show theme image -->
                                    <br>{$row['theme']} <!-- Debugging: Show the image path -->
                                </td>
                                <td>{$row['decor']}</td>
                                <td>{$row['entertain']}</td>
                                <td>{$row['catering']}</td>
                                <td>{$row['food_type']}</td>
                                <td>{$row['additional_req']}</td>
                                <td>{$row['guest_count']}</td>
                                <td>
                                    <form action='' method='POST'>
                                        <input type='hidden' name='decor_id' value='{$row['decor_id']}'>
                                        <input type='number' name='total_cost' value='{$row['total_cost']}' required>
                                        <input type='submit' value='Submit Cost'>
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


