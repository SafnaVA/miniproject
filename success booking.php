<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Successful</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to bottom right, #e0f7fa, #b2ebf2);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
            text-align: center;
            position: relative;
        }

        .marquee {
            position: absolute;
            top: 0;
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 10px 0;
            white-space: nowrap;
            overflow: hidden;
        }

        .marquee span {
            display: inline-block;
            animation: marquee 15s linear infinite;
        }

        @keyframes marquee {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }

        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 600px;
            width: 90%;
            z-index: 1;
        }

        h1 {
            color: #4CAF50;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2em;
            margin-bottom: 30px;
        }

        .button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="marquee">
        <marquee>Thank you for choosing us! We hope you have a great experience!</marquee>
    </div>
    <div class="container">
        <h1>Booking Successful!</h1>
        <p>Your booking has been successfully completed. We look forward to seeing you!</p>
        <p>If you have any questions or need further assistance, feel free to contact us.</p>
        <a href="front.php" class="button">Return to Homepage</a>
    </div>
</body>
</html>
