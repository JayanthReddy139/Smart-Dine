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

if (isset($_GET['cart_id'])) {
    $cart_id = $_GET['cart_id'];

    // Delete the item from the cart
    $delete_sql = "DELETE FROM cart WHERE cart_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $cart_id);

    if ($stmt->execute()) {
        // Redirect back to the cart page
        header("Location: cart.php");
    } else {
        echo "Error removing item.";
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>
