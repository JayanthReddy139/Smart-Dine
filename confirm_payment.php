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

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user id and booking id from session
$user_id = $_SESSION['user_id'];
$booking_id = $_SESSION['booking_id'] ?? null;

// Update payment status to 'Paid'
if ($booking_id) {
    $stmt = $conn->prepare("UPDATE bookings SET payment_status = 'Paid' WHERE id = ? AND user_id = ?");
    
    if ($stmt) {
        $stmt->bind_param("ii", $booking_id, $user_id);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Confirmation</title>
    <meta http-equiv="refresh" content="3;url=dashboard.php"> <!-- Redirects after 3 seconds -->
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <style>
        body {
            font-family: 'LEMON MILK', monospace;
            background-color: #f0f4f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #4CAF50; /* Green color for success message */
            margin-bottom: 20px;
        }

        p {
            color: #555;
            font-size: 18px;
        }

        .redirect-message {
            font-size: 16px;
            color: #888;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment Successful!</h1>
        <p>You will be redirected shortly...</p>
        <p class="redirect-message">Thank you for your booking!</p>
    </div>
</body>
</html>
