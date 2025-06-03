

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
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
        main {
            flex: 1;
            padding: 20px;
        }
        .feedback-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 5px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        footer {
            text-align: center;
            padding: 10px 0;
            background-color: #f1f1f1;
            width: 100%;
        }
    </style>
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
                <li><a href="manage_cancel.php">View cancels</a></li>
                <li><a href="manage_confirm.php">View Cofirmed bookings</a></li>


            </ul>
        </aside>
        
        <main class="main-content">
            <h2>Feedback Management</h2>
            <?php
            $conn = new mysqli("localhost", "root", "", "event");

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            // Fetch feedback data
            $sql = "SELECT
            f. feedback_id, f.eventname, f.yourname, f.comments, f.rating FROM feedback f
            JOIN signup s 
            ON f.userid=s.userid
            WHERE (s.action != 'blocked' OR s.action IS NULL)";
            if ($data = mysqli_query($conn, $sql)) {
                if (mysqli_num_rows($data) > 0) {
                    // Start the table
                    echo "<table class='feedback-table'>";
                    echo "<tr><th>Feedback ID</th>";
                    echo "<th>Event Name</th>";
                    echo "<th>Your Name</th>";
                    echo "<th>Comments</th>";
                    echo "<th>Rating</th></tr>";

                    // Fetch each row and display it
                    while ($row = mysqli_fetch_array($data)) {
                        echo "<tr>";
                        echo "<td>" . $row['feedback_id'] . "</td>";
                        echo "<td>" . $row['eventname'] . "</td>";
                        echo "<td>" . $row['yourname'] . "</td>";
                        echo "<td>" . $row['comments'] . "</td>";
                        echo "<td>" . $row['rating'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<p>No records matching.</p>";
                }
            }
            ?>
        </main>
    </div>
    
   
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
