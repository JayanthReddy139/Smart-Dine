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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize input
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $order_ref = $conn->real_escape_string($_POST['order-ref']);
    $rating = (int)$_POST['rating'];
    $favorite_item = $conn->real_escape_string($_POST['favorite-item']);
    $preferred_time = $conn->real_escape_string($_POST['preferred-time']);
    $message = $conn->real_escape_string($_POST['message']);

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO feedback (name, email, order_ref, rating, favorite_item, preferred_time, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissss", $name, $email, $order_ref, $rating, $favorite_item, $preferred_time, $message);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        // Feedback successfully submitted
        $thank_you_message = "Thank you for your feedback!";
    } else {
        // Error occurred
        $error_message = "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Page</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'LEMON MILK', monospace;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 1rem;
        }

        .feedback-form {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 500px;
            margin-top: 1rem;
        }

        h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            text-align: center;
            color: #ff5a00;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: 'LEMON MILK', monospace;
            font-size: 1rem;
            background-color: #ffffff;
            appearance: none;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="%23ff5a00"><path d="M10 12l-6 4V4l6 4 6-4v12l-6-4z"/></svg>');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 1rem;
            transition: border-color 0.3s ease, background-color 0.3s ease;
        }

        textarea {
            resize: none;
        }

        button {
            width: 100%;
            padding: 0.75rem;
            background-color: #ff5a00;
            border: none;
            border-radius: 5px;
            color: white;
            font-family: 'LEMON MILK', monospace;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #ff8c00;
        }

        .thank-you-message, .error-message {
            display: <?php echo isset($thank_you_message) || isset($error_message) ? 'block' : 'none'; ?>;
            font-size: 1.5rem;
            color: <?php echo isset($thank_you_message) ? '#1ba100' : '#ff0000'; ?>;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Feedback</h2>
        <form class="feedback-form" id="feedback-form" action="feedback.php" method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="order-ref">Order Reference Number</label>
                <input type="text" id="order-ref" name="order-ref">
            </div>
            <div class="form-group">
                <label for="rating">Rating (out of 5)</label>
                <select id="rating" name="rating" required>
                    <option value="">Select a rating</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div class="form-group">
                <label for="favorite-item">Favorite Item</label>
                <input type="text" id="favorite-item" name="favorite-item" required>
            </div>
            <div class="form-group">
                <label for="preferred-time">Preferred Dining Time</label>
                <input type="text" id="preferred-time" name="preferred-time" placeholder="e.g., 7:00 PM" required>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="4" required></textarea>
            </div>
            <button type="submit">Submit Feedback</button>
        </form>

        <?php if (isset($thank_you_message)): ?>
            <p class="thank-you-message"><?php echo $thank_you_message; ?></p>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
