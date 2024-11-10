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

// Fetch user id from session
$user_id = $_SESSION['user_id'];

// Ensure session variables are set
if (isset($_SESSION['num_persons'], $_SESSION['num_tables'], $_SESSION['booking_date'], $_SESSION['booking_time'], $_SESSION['suggestions'])) {
    // Store session variables into local variables
    $num_persons = $_SESSION['num_persons'];
    $num_tables = $_SESSION['num_tables'];
    $booking_date = $_SESSION['booking_date'];
    $booking_time = $_SESSION['booking_time'];
    $suggestions = $_SESSION['suggestions'];

    // Prepare the insert statement for the bookings table
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, num_persons, num_tables, booking_date, booking_time, suggestions, payment_status, created_at) VALUES (?, ?, ?, ?, ?, ?, 'Pending', NOW())");

    if ($stmt) {
        $stmt->bind_param("iiissss", $user_id, $num_persons, $num_tables, $booking_date, $booking_time, $suggestions);

        if ($stmt->execute()) {
            $_SESSION['booking_id'] = $stmt->insert_id; // Store booking ID for confirmation
            unset($_SESSION['num_persons'], $_SESSION['num_tables'], $_SESSION['booking_date'], $_SESSION['booking_time'], $_SESSION['suggestions']);
            header("Location: payment_confirm.php"); // Redirect to the payment confirm page
            exit();
        } else {
            die("Error processing your booking. Please try again.");
        }
    } else {
        die("Error preparing statement: " . $conn->error);
    }
} else {
    die("Booking details are missing. Please ensure the booking form is completed properly.");
}

$conn->close();
?>
