<?php
// Include database connection
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $role = $_POST['role'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hashing password

    // Insert into the users table
    $sql = "INSERT INTO users (name, role, contact_number, address, password) 
            VALUES ('$name', '$role', '$contact_number', '$address', '$password')";

    if (mysqli_query($conn, $sql)) {
        header("Location: users.php"); // Redirect to users list
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <ul class="sidebar-links">
                <li><a href="admin_dashboard.php" class="sidebar-btn">Dashboard</a></li>
                <li><a href="package.php" class="sidebar-btn">Package</a></li>
                <li><a href="product.php" class="sidebar-btn">Product</a></li>
                <li><a href="cargo.php" class="sidebar-btn">Cargo</a></li>
                <li><a href="truck.php" class="sidebar-btn">Truck</a></li>
                <li><a href="users.php" class="sidebar-btn">Users</a></li>
                <li><a href="reports.php" class="sidebar-btn">Reports</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Add New User</h1>
                <a href="index.php" class="logout-btn">Logout</a>
            </header>

            <div class="dashboard-main-container">
                <form action="add_user.php" method="POST">
                    <label for="name">Name:</label><br>
                    <input type="text" id="name" name="name" required><br><br>

                    <label for="role">Role:</label><br>
                    <select id="role" name="role">
                        <option value="admin">Admin</option>
                        <option value="driver">Driver</option>
                        <option value="customer">Customer</option>
                    </select><br><br>

                    <label for="contact_number">Contact Number:</label><br>
                    <input type="text" id="contact_number" name="contact_number" required><br><br>

                    <label for="address">Address:</label><br>
                    <textarea id="address" name="address" required></textarea><br><br>

                    <label for="password">Password:</label><br>
                    <input type="password" id="password" name="password" required><br><br>

                    <input type="submit" value="Add User">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
