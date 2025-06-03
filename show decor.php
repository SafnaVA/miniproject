<html>
<head>
    <title>Display Booking</title>
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
            width: 600px;
            margin: 30px;
            padding: 5px;
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 10px;
            padding:20px;
        }

        table {
            width: 100%;
            height: 100px;
            margin-top: 5px;
        }

        th, td {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: black;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .continue-button {
            display: block;
            width: 200px;
            margin: 40px auto;
            padding: 10px;
            text-align: center;
            background-color: black;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }

        .continue-button:hover {
            background-color: blue;
        }

        .summary {
            margin-top: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f1f1f1;
            text-align: center;
        }

        .edit-button {
            text-align: center;
            background-color: green;
            color: white;
            padding: 10px;
            border-radius: 5px;
            text-decoration: none;
        }

        .edit-button:hover {
            background-color: darkgreen;
        }
    </style>
    <script>
        function continueBooking() {
            alert("Booking successful");
            window.location.href = "success booking.php"; // Redirect to the booking success page
        }
    </script>
</head>
<body>
    <!-- Navigation Bar -->
    <div class="navbar">
        <div>
            <a href="view_booking_status.php">View Booking Status</a>
            <a href="feedback.php">Add Feedback</a>
            <a href="confirmandcancel.php">Confirm/cancel booking</a>
        </div>
        <div>
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="container">
        <h1>Booking Invoice</h1>

        <?php
        session_start(); // Start the session

        $dbcon = mysqli_connect("localhost", "root", "", "event");

        // Ensure user ID is set in the session
        if (isset($_SESSION['event_id'])) {
            $eventid = $_SESSION['event_id'];
            $stmt = $dbcon->prepare("SELECT * FROM booking WHERE event_id = ?");
            $stmt->bind_param("i", $eventid); // Assuming userid is an integer

            // Execute the statement
            $stmt->execute();
            $data = $stmt->get_result();

            if (mysqli_num_rows($data) > 0) {
                echo "<table border=3>";
                echo "<tr><th>EVENT NAME</th>";
                echo "<th>FULL NAME</th>";
                echo "<th>LOCATION</th>";
                echo "<th>EVENT DATE FROM</th>";
                echo "<th>EVENT DATE TO</th>";
                echo "<th>START TIME</th>";
                echo "<th>END TIME</th>";
                echo "<th>ACTION</th>"; // Added action column for edit button

                while ($row = mysqli_fetch_array($data)) {
                    echo "<tr>";
                    echo "<td>" . $row['event_name'] . "</td>";
                    echo "<td>" . $row['full_name'] . "</td>";
                    echo "<td>" . $row['location'] . "</td>";
                    echo "<td>" . $row['event_date_from'] . "</td>";
                    echo "<td>" . $row['event_date_to'] . "</td>";
                    echo "<td>" . $row['start_time'] . "</td>";
                    echo "<td>" . $row['end_time'] . "</td>";
                    echo "<td><a href='editbooking.php?id=" . $row['event_id'] . "'>Edit</a></td>"; // Edit link with event ID
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "No records matching";
            }

            // Fetch decoration items
            $stmt2 = $dbcon->prepare("SELECT * FROM decor WHERE event_id = ?");
            $stmt2->bind_param("i", $eventid);
            $stmt2->execute();
            $data2 = $stmt2->get_result();

            if (mysqli_num_rows($data2) > 0) {
                echo "<h1>Decoration Items</h1>";
                echo "<table border=3>";
                echo "<tr><th>THEME</th>";
                echo "<th>DECORATION ITEMS</th>";
                echo "<th>ENTERTAINMENT</th>";
                echo "<th>CATERING REQUIREMENTS</th>";
                echo "<th>FOOD TYPE</th>";
                echo "<th>ADDITIONAL REQUIREMENTS</th>";
                echo "<th>GUEST COUNT</th>";
                echo "</tr>";

                while ($row2 = mysqli_fetch_array($data2)) {
                    echo "<tr>";
                    echo "<td><img src='" . htmlspecialchars($row2["theme"]) . "' alt='Theme Image'></td>"; // Display the theme image
                    echo "<td>" . $row2['decor'] . "</td>";
                    echo "<td>" . $row2['entertain'] . "</td>";
                    echo "<td>" . $row2['catering'] . "</td>";
                    echo "<td>" . $row2['food_type'] . "</td>";
                    echo "<td>" . $row2['additional_req'] . "</td>";
                    echo "<td>" . $row2['guest_count'] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
                // Single "Edit" button for decoration items
                echo "<div style='text-align: center;'>";
                echo "<a href='event_selection.php' class='edit-button'>Edit Decoration Items</a>"; // Edit button for decoration items
                echo "</div>";
            } else {
                echo "No records matching decoration items.";
            }

        } else {
            echo "User not logged in";
        }
        ?>

        <button class="continue-button" onclick="continueBooking()">Confirm Booking</button>
    </div>
</body>
</html>
