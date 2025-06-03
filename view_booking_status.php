<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    die("You must be logged in to view this page.");
}

// Assuming user ID is stored in the session
$user_id = $_SESSION['userid'];

// Create connection
$conn = new mysqli("localhost", "root", "", "event");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch booking details along with decor details for the logged-in user
$sql = "SELECT b.event_name, b.event_date_from,b.event_date_to, d.theme, d.decor, d.entertain, d.catering, 
        d.food_type, d.additional_req, d.guest_count, d.total_cost, b.status, b.rejection_reason 
        FROM booking b 
        JOIN decor d ON b.event_id = d.event_id 
        WHERE b.userid = ?"; // Use 'userid' as per your schema

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id); // Use the correct variable

if (!$stmt->execute()) {
    die("Execute failed: " . $stmt->error);
}

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Booking Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .rejected {
            color: red;
        }
        img {
            max-width: 100px; /* Adjust width as necessary */
            height: auto;
        }
    </style>
</head>
<body>

    <h1>View Booking Status</h1>

    <table>
        <thead>
            <tr>
                <th>Event Name</th>
                <th>Event Date From</th>
                <th>Event Date To</th>
                <th>Theme</th>
                <th>Decor</th>
                <th>Entertainment</th>
                <th>Catering</th>
                <th>Food Type</th>
                <th>Additional Requirements</th>
                <th>Guest Count</th>
                <th>Total Cost</th>
                <th>Status</th>
                <th>Rejection Reason</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["event_name"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["event_date_from"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["event_date_to"]) . "</td>";
                    echo "<td><img src='" . htmlspecialchars($row["theme"]) . "' alt='Theme Image'></td>"; // Display the theme image
                    echo "<td>" . htmlspecialchars($row["decor"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["entertain"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["catering"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["food_type"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["additional_req"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["guest_count"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["total_cost"]) . "</td>";
                    echo "<td>" . htmlspecialchars($row["status"]) . "</td>";
                    echo "<td class='" . ($row["status"] == 'Rejected' ? 'rejected' : '') . "'>" . htmlspecialchars($row["rejection_reason"]) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='12'>No bookings found.</td></tr>";
            }
            $stmt->close();
            $conn->close();
            ?>
        </tbody>
    </table>

</body>
</html>
