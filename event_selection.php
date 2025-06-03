<?php
// Start session to retrieve user session data
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

$userid = $_SESSION['userid'];
$con = new mysqli("localhost", "root", "", "event");

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Fetch all events booked by the user
$sql = "SELECT * FROM `booking` WHERE `userid` = '$userid'"; // Ensure this is correct for your events table
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Booked Events</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
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
            background-color: black;
            border-radius: 5px;
        }

        .container {
            width: 80%;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #333;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .edit-link {
            background-color: #007BFF;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
        }

        .edit-link:hover {
            background-color: #0056b3;
        }

        .no-events {
            text-align: center;
            font-size: 18px;
            color: #555;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<div class="navbar">
    <div>
        <a href="view_booking_status.php">View Booking Status</a>
        <a href="feedback.php">Add Feedback</a>
        <a href="confirmandcancel.php">Confirm/Cancel Booking</a>
    </div>
    <div>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h1>Your Booked Events</h1>

    <?php
    if ($result->num_rows > 0) {
        // Display events in a table format
        echo "<table>";
        echo "<tr><th>Event Name</th><th>Action</th></tr>";

        while ($row = $result->fetch_assoc()) {
            $event_id = $row['event_id'];
            $event_name = $row['event_name'];
           

            echo "<tr>";
            echo "<td>" . htmlspecialchars($event_name) . "</td>";

            echo "<td><a href='editdecor.php?event_id=$event_id' class='edit-link'>Edit decor</a></td>"; // Edit link with event ID
           
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p class='no-events'>You have not booked any events yet. Please book an event first.</p>";
    }

    $con->close();
    ?>
</div>

</body>
</html>
