<?php
$con = new mysqli("localhost", "root", "", "event");

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query for total bookings
$totalBookingsQuery = "SELECT COUNT(event_id) AS total_bookings FROM booking";
$result = $con->query($totalBookingsQuery);
$totalBookings = $result->fetch_assoc()['total_bookings'];

// Query for total logged-in users
$totalUsersQuery = "SELECT COUNT(userid) AS total_users FROM signup";
$result = $con->query($totalUsersQuery);
$totalUsers = $result->fetch_assoc()['total_users'];

// Query for total feedbacks
$totalFeedbackQuery = "SELECT COUNT(feedback_id) AS total_feedback FROM feedback";
$result = $con->query($totalFeedbackQuery);
$totalFeedback = $result->fetch_assoc()['total_feedback'];

$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
    <header>
        <nav>
            <div class="nav-container">
                <h1>Welcome, Admin</h1>
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
                <li><a href="manage_cancel.php">View Cancels</a></li>
                <li><a href="manage_confirm.php">View Cofirmed bookings</a></li>

            </ul>
        </aside>
        
        <main class="main-content">
            <h2>Dashboard Overview</h2>
            <div class="dashboard-stats">
                <div class="stat">
                    <h3>Total Bookings</h3>
                    <p><?php echo $totalBookings; ?></p>
                </div>
                <div class="stat">
                    <h3>Total Users</h3>
                    <p><?php echo $totalUsers; ?></p>
                </div>
                <div class="stat">
                    <h3>Total Feedbacks</h3>
                    <p><?php echo $totalFeedback; ?></p>
                </div>
            </div>
        </main>
    </div>
    
    <footer>
        <p>&copy; 2024 Your Company</p>
    </footer>
</body>
</html>


