<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f9f9f9;
            padding: 20px;
             background-image: url("https://www.qceventplanning.com/blog/wp-content/uploads/2022/09/How-to-brand-your-event-planning-business-Feature-Image.jpg");
              background-size: cover;
        }
        form {
            background-color: #fff;
            padding: 40px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 300px;
            width: 100%;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .star-rating {
            display: flex;
            direction: row-reverse;
            justify-content: center;
            margin-bottom: 10px;
        }
        .star-rating input {
            display: none;
        }
        .star {
            font-size: 20px;
            color: #ccc;
            cursor: pointer;
        }
        .star:hover,
        .star:hover ~ .star {
            color: #f39c12;
        }
        .star-rating input:checked ~ .star {
            color: #f39c12;
        }
        button {
            padding: 8px 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <form id="feedbackForm" action="" method="POST">
        <h1 style="text-align: center;">Feedback</h1>
        <label for="eventName">Event Name:</label>
        <input type="text" id="eventName" name="eventName" required>

        <label for="yourName">Your Name:</label>
        <input type="text" id="yourName" name="yourName" required>

        <label for="comments">Comments:</label>
        <textarea id="comments" name="comments" rows="2" required></textarea>

        <label>Rating:</label>
        <div class="star-rating">
            <input type="radio" id="star5" name="rating" value="5" required />
            <label class="star" for="star5">★</label>
            <input type="radio" id="star4" name="rating" value="4" />
            <label class="star" for="star4">★</label>
            <input type="radio" id="star3" name="rating" value="3" />
            <label class="star" for="star3">★</label>
            <input type="radio" id="star2" name="rating" value="2" />
            <label class="star" for="star2">★</label>
            <input type="radio" id="star1" name="rating" value="1" />
            <label class="star" for="star1">★</label>
        </div>

        <button type="submit" name="submit">Submit Feedback</button>
    </form>

    <?php
    session_start();
    $con = new mysqli("localhost", "root", "", "event");
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    if (isset($_POST['submit'])) {
        $name = $_POST['eventName'];
        $pname = $_POST['yourName'];
        $cmts = $_POST['comments'];
        $rating = $_POST['rating'];
        $userid = $_SESSION['userid'] ?? null;
        $event_id = $_SESSION['event_id'] ?? null;

        if ($userid && $event_id) {
            $insertQuery = "INSERT INTO feedback (userid, event_id, eventname, yourname, comments, rating) 
            VALUES ('$userid', '$event_id', '$name', '$pname', '$cmts', '$rating')";

            if ($con->query($insertQuery) === TRUE) {
                exit;
            } else {
                echo "Error: " . $insertQuery . "<br>" . $con->error;
            }
        } else {
            echo "User ID or Event ID not set.";
        }
    }
    $con->close();
    ?>

    <script>
        // Removed event.preventDefault() to allow form submission
    </script>

</body>
</html>
