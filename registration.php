<?php
$message = "";

// Process the form if it has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    // Collect input data
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];

    // Prepare SQL statement
    $sql = "INSERT INTO Users (name, username, email, phone, gender, password) VALUES ('$name', '$username', '$email', '$phone', '$gender', '$password')";

    if ($conn->query($sql) === TRUE) {
        $message = "Registration successful!";
    } else {
        $message = "Error: " . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>

<!-- HTML form here -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    </head>
    <style>
        body {
            font-family: 'LEMON MILK', monospace;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Changed from height to min-height */
            padding: 1rem; /* Added padding for small screens */
            box-sizing: border-box; /* Ensures padding is included in height calculation */
        }

        .register-form {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 500px;
            max-width: 100%; /* Ensures form doesn't exceed screen width */
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            text-align: center;
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
        input[type="password"],
        input[type="tel"] {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        .gender-group {
            display: flex;
            justify-content: space-around;
            margin-top: 0.5rem;
        }

        input[type="radio"] {
            display: none;
        }

        label.radio {
            background-color: #f1f1f1;
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        input[type="radio"]:checked + label.radio {
            background-color: #ff5a00;
            color: white;
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

        p.lead {
            text-align: center;
            margin-top: 1rem;
        }

        p.lead a {
            color: #ff5a00;
            text-decoration: none;
        }

        p.lead a:hover {
            text-decoration: underline;
        }

        .message {
            text-align: center;
            margin-bottom: 1rem;
            color: #06991d;
        }

        @media (max-width: 480px) {
            .register-form {
                width: 90%; /* Adjust form width for small screens */
            }
        }
    </style>
<body>
    <div class="container">
        <form class="register-form" action="" method="POST">
            <h2>Register</h2>
            <?php if ($message): ?>
                <div class="message"><?php echo $message; ?></div>
            <?php endif; ?>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" required placeholder="e.g. +1234567890">
            </div>
            <div class="form-group">
                <label>Gender</label>
                <div class="gender-group">
                    <input type="radio" id="male" name="gender" value="male" required>
                    <label for="male" class="radio">Male</label>
                    
                    <input type="radio" id="female" name="gender" value="female" required>
                    <label for="female" class="radio">Female</label>
                </div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
            </div>
            <button type="submit">Register</button>
            <p class="lead">Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>

    <script>
        const form = document.querySelector('.register-form');
        form.addEventListener('submit', function (e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            
            if (password !== confirmPassword) {
                alert('Passwords do not match!');
                e.preventDefault(); // Prevent form submission
            }
        });
    </script>
</body>
</html>
