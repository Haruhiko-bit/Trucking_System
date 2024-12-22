<?php
// Start the session at the very beginning of the page
session_start();

// Include the database connection
include 'config.php';

$error = '';
$success = '';

// Handle login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL query to fetch user data based on username
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables for user ID and role
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role']; // Store the role in session
            
            // Redirect based on user role
            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php"); // Redirect to Admin dashboard
            } elseif ($user['role'] == 'driver') {
                header("Location: driver_dashboard.php"); // Redirect to Driver dashboard
            } elseif ($user['role'] == 'customer') {
                header("Location: customer_dashboard.php"); // Redirect to Customer dashboard
            }
            exit();
        } else {
            $error = 'Invalid password!';
        }
    } else {
        $error = 'Username not found!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        input {
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
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <?php if ($error) { echo "<p class='error'>$error</p>"; } ?>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
        <div class="register-link">
            <p>Don't have an account?</p>
            <a href="register.php">Register here</a>
        </div>
    </div>
</body>
</html>

<?php
// Display success message if provided
if (isset($_GET['message'])) {
    echo "<p style='color: green; text-align: center; font-weight: bold; position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #d4edda; padding: 10px; border-radius: 5px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>".htmlspecialchars($_GET['message'])."</p>";
}
?>
