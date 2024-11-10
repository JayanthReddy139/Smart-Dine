<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <title>My Bookings</title>
    <style>
        body {
            font-family: 'LEMON MILK', monospace;
            background-color: #f0f4f8;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #ff5a00;
            margin-bottom: 20px;
        }

        h3 {
            color: #444;
            margin-bottom: 5px;
        }

        p {
            margin: 5px 0;
            color: #555;
        }

        hr {
            border: 1px solid #ddd;
            margin: 20px 0;
        }

        .estimate-time {
            color: #888; /* Optional: Change color for better visibility */
            font-style: italic; /* Italic style for emphasis */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>My Bookings</h1>

        <?php
        session_start();

        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }

        // Database connection
        $servername = "127.0.0.1";
        $db_username = "root";
        $db_password = "";
        $dbname = "smartdine";

        $conn = new mysqli($servername, $db_username, $db_password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $user_id = $_SESSION['user_id'];

        // Fetch bookings for the user
        $sql = "SELECT * FROM bookings WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if there are bookings
        if ($result->num_rows > 0) {
            while ($booking = $result->fetch_assoc()) {
                if (isset($booking['booking_id'])) {
                    echo "<h3>Booking ID: " . htmlspecialchars($booking['booking_id']) . "</h3>";
                } else {
                    echo "<h3>Booking ID not available</h3>";
                }
                echo "<p>Number of Persons: " . htmlspecialchars($booking['num_persons']) . "</p>";
                echo "<p>Number of Tables: " . htmlspecialchars($booking['num_tables']) . "</p>";
                echo "<p>Booking Date: " . htmlspecialchars($booking['booking_date']) . "</p>";
                echo "<p>Booking Time: " . htmlspecialchars($booking['booking_time']) . "</p>";
                echo "<p>Suggestions: " . htmlspecialchars($booking['suggestions']) . "</p>";
                echo "<p class='estimate-time'>The minimum estimate time is 15-30 minutes.</p>"; // Added estimate time message
                echo "<hr>";
            }
        } else {
            echo "<p class='no-bookings'>No bookings found.</p>";
        }

        $stmt->close();
        $conn->close();
        ?>
    </div>
</body>
</html>
