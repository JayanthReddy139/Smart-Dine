<?php
session_start();

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

// Fetch food items
$sql = "SELECT item_id, item_name, item_description, item_price, item_img FROM menuitems";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Menu | Smart Dine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f4f8;
        }
        .food-item {
            margin-bottom: 30px;
        }
        .food-item img {
            width: 100%;
            height: auto;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Our Food Menu</h2>
    <div class="row">
        <?php
        if ($result->num_rows > 0) {
            while ($item = $result->fetch_assoc()) {
                echo '
                <div class="col-md-4 food-item text-center">
                    <img src="' . htmlspecialchars($item['item_img']) . '" alt="' . htmlspecialchars($item['item_name']) . '">
                    <h4>' . htmlspecialchars($item['item_name']) . '</h4>
                    <p>' . htmlspecialchars($item['item_description']) . '</p>
                    <p><strong>Price: $' . htmlspecialchars($item['item_price']) . '</strong></p>
                    <button class="btn btn-primary" onclick="addToCart(' . htmlspecialchars($item['item_id']) . ')">Add to Cart</button>
                </div>
                ';
            }
        } else {
            echo '<p>No food items available.</p>';
        }
        $conn->close();
        ?>
    </div>
</div>

<script>
    function addToCart(itemId) {
        // Logic to add item to cart (could use AJAX to communicate with a backend)
        alert("Item " + itemId + " added to cart!");
    }
</script>

</body>
</html>
