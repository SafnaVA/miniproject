<?php
session_start();


// Create connection
$conn = new mysqli("localhost", "root", "", "event");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve all canceled bookings (is_cancelled = 0)
$canceled_bookings_sql =  "SELECT b.event_id,b.event_name, b.full_name, b.location, b.start_time, b.end_time FROM booking b
JOIN signup s
ON  b.userid=s.userid
WHERE 
B.is_cancelled = 2 AND  (s.action != 'blocked' OR s.action IS NULL)";
$result = $conn->query($canceled_bookings_sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cancelled Bookings Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        header {
            background-color: black;
            color: rgb(251, 243, 243);
             padding: 10px 0;
           }

.nav-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.logout {
    color: white;
    text-decoration: none;
}

.container {
    display: flex;
    flex: 1;
}

.sidebar {
    width: 200px;
    background-color: #0f0f0f;
    padding: 20px;
}

.sidebar-links {
    list-style-type: none;
    padding: 0;
}

.sidebar-links li {
    margin: 10px 0;
}

.sidebar-links a {
    text-decoration: none;
    color: #faf0f0;
    display: block;
    padding: 10px;
}

.sidebar-links a:hover {
    background-color: #090909;
}

        h2 {
            color: white;
            text-align:center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
          
        }
        th {
            background-color: black;
            color: white;
        }
    </style>
</head>

<header>
        <nav>
            <div class="nav-container">
                <h1>Welcome, Admin</h1>
                <h2>Confirmed bookings</h2>
                <a href="front.php" class="logout">Logout</a>
            </div>
        </nav>
    </header>

    <div class="container">
        <aside class="sidebar">
            <ul class="sidebar-links">
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="view user.php">View Users</a></li>
                <li><a href="view_booking.php">View Bookings</a></li>
                <li><a href="manage_bookings.php">Manage Bookings</a></li>
                <li><a href="view_feedback.php">View Feedback</a></li>
                <li><a href="manage_cancel.php">View Cancels</a></li>
                <li><a href="manage_confirm.php">View Cofirmed bookings</a></li>

            </ul>
        </aside>
<body>


    <table>
        <tr>
            <th>Event ID</th>
            <th>Event Name</th>
            <th>Full Name</th>
            <th>Location</th>
            <th>Start Time</th>
            <th>End Time</th>
        </tr>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['event_id']; ?></td>
                    <td><?php echo $row['event_name']; ?></td>
                    <td><?php echo $row['full_name']; ?></td>
                    <td><?php echo $row['location']; ?></td>
                    <td><?php echo $row['start_time']; ?></td>
                    <td><?php echo $row['end_time']; ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">No cofirmed bookings found.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
