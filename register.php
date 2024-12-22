<?php
// Include database connection
include 'config.php';

$error = '';
$success = '';

// Handle registration
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];

    // Password validation
    if ($password != $confirm_password) {
        $error = 'Passwords do not match!';
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into the database
        $sql = "INSERT INTO users (name, username, password, role, contact_number, address) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $name, $username, $hashed_password, $role, $contact_number, $address);
        
        if ($stmt->execute()) {
            // Successful registration, redirect to login page
            $success = 'Registration successful! You can now login.';
            header('Location: index.php?message=' . urlencode($success)); // Redirect to login page with success message
            exit; // Ensure no further script execution after redirect
        } else {
            $error = 'Error: Could not register the user!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Embedded CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border: none;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            text-align: center;
        }

        .register-link {
            display: block;
            text-align: center;
            margin-top: 10px;
        }

        .register-link a {
            color: #007bff;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .role-selection {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Register</h2>
        <?php if ($error) { echo "<p class='error'>$error</p>"; } ?>
        <form action="" method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <input type="text" name="contact_number" placeholder="Contact Number" required>
            <textarea name="address" placeholder="Address" required></textarea>
            
            <div class="role-selection">
                <label for="role">Role: </label>
                <select name="role" id="role" required>
                    <option value="admin">Admin</option>
                    <option value="driver">Driver</option>
                    <option value="customer">Customer</option>
                </select>
            </div>
            
            <button type="submit" name="register">Register</button>
        </form>
        <div class="register-link">
            <p>Already have an account?</p>
            <a href="index.php">Login here</a>
        </div>
    </div>
</body>
</html>
