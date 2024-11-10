<?php
session_start();

// Ensure the user is logged in
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

// Get item ID and quantity from the request
$item_id = isset($_GET['item_id']) ? (int)$_GET['item_id'] : 0;
$quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 1;

// Validate inputs
if ($item_id > 0 && $quantity > 0) {
    $user_id = $_SESSION['user_id'];
    
    // Check if the item is already in the cart
    $check_sql = "SELECT quantity FROM cart WHERE user_id = ? AND item_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ii", $user_id, $item_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Item exists in the cart, update quantity
        $row = $result->fetch_assoc();
        $new_quantity = $row['quantity'] + $quantity;

        $update_sql = "UPDATE cart SET quantity = ? WHERE user_id = ? AND item_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("iii", $new_quantity, $user_id, $item_id);
        $update_stmt->execute();
        $update_stmt->close();
    } else {
        // Item does not exist, insert a new row
        $insert_sql = "INSERT INTO cart (user_id, item_id, quantity) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("iii", $user_id, $item_id, $quantity);
        $insert_stmt->execute();
        $insert_stmt->close();
    }
}

// Redirect back to the menu or wherever appropriate
header("Location: online_ordering.php");
exit();

$conn->close();
?>
