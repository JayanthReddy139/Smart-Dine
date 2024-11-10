<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Set a fixed total amount
$total_amount = 500; // Fixed amount
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment | Smart Dine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'LEMON MILK', monospace;
            background-color: #f0f4f8;
        }
    </style>
</head>
<body>
    <header class="bg-dark text-white text-center p-4">
        <h1>Payment</h1>
    </header>

    <div class="container mt-5">
        <h2>Total Amount: ₹ <?php echo $total_amount; ?></h2>

        <!-- Mock payment options -->
        <form action="confirm_payment.php" method="post">
            <div class="mb-3">
                <label for="paymentMethod" class="form-label">Choose Payment Method:</label>
                <select id="paymentMethod" name="payment_method" class="form-select">
                    <option value="credit_card">Credit Card</option>
                    <option value="debit_card">Debit Card</option>
                    <option value="upi">UPI</option>
                </select>
            </div>
            <input type="hidden" name="total_amount" value="<?php echo $total_amount; ?>">
            <button type="submit" class="btn btn-primary">Confirm Payment</button>
        </form>
    </div>

    <footer class="bg-dark text-white py-4 text-center">
        <p>&copy; 2024 Smart Dine. All Rights Reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
