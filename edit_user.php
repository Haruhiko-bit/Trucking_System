<?php
// Include database connection
include 'config.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $role = $_POST['role'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];

    // Update user information
    $sql = "UPDATE users SET name='$name', role='$role', contact_number='$contact_number', address='$address' WHERE user_id='$user_id'";

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
    <title>Edit User</title>
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
                <h1>Edit User</h1>
                <a href="index.php" class="logout-btn">Logout</a>
            </header>

            <div class="dashboard-main-container">
                <form action="edit_user.php?id=<?php echo $user['user_id']; ?>" method="POST">
                    <label for="name">Name:</label><br>
                    <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required><br><br>

                    <label for="role">Role:</label><br>
                    <select id="role" name="role">
                        <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                        <option value="driver" <?php echo ($user['role'] == 'driver') ? 'selected' : ''; ?>>Driver</option>
                        <option value="customer" <?php echo ($user['role'] == 'customer') ? 'selected' : ''; ?>>Customer</option>
                    </select><br><br>

                    <label for="contact_number">Contact Number:</label><br>
                    <input type="text" id="contact_number" name="contact_number" value="<?php echo $user['contact_number']; ?>" required><br><br>

                    <label for="address">Address:</label><br>
                    <textarea id="address" name="address" required><?php echo $user['address']; ?></textarea><br><br>

                    <input type="submit" value="Update User">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
