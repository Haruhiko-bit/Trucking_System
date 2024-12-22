<?php
// Include database connection
include 'config.php';

// Fetch all users from the database
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .dashboard-container {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 220px;
            background-color: #333; /* Sidebar background color */
            color: white;
            padding-top: 20px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-links li {
            padding: 15px;
            text-align: center;
        }

        .sidebar-links li a {
            color: white;
            text-decoration: none;
            display: block;
            font-size: 16px;
        }

        .sidebar-links li a:hover {
            background-color: #444;
            transition: 0.3s;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        header h1 {
            font-size: 24px;
        }

        .logout-btn {
            padding: 10px 20px;
            background-color: #ff5722;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .logout-btn:hover {
            background-color: #e64a19;
            transition: 0.3s;
        }

        .dashboard-main-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 20px;
            margin-bottom: 20px;
        }

        /* Table Styles */
        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        td {
            font-size: 14px;
        }

        /* Action Buttons Styles */
        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-user-btn {
            background-color: #4CAF50;
            color: white;
        }

        .add-user-btn:hover {
            background-color: #45a049;
        }

        .edit-btn {
            background-color: #008CBA;
            color: white;
        }

        .edit-btn:hover {
            background-color: #007bb5;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
        }

        .delete-btn:hover {
            background-color: #e41e15;
        }

        /* Button container style for neat spacing */
        .action-buttons a {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
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
                <h1>Users</h1>
                <a href="index.php" class="logout-btn">Logout</a>
            </header>

            <div class="dashboard-main-container">
                <h2>User List</h2>

                <!-- User Table Container -->
                <div class="table-container">
                    <table border="1">
                        <tr>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['role']; ?></td>
                                <td><?php echo $row['contact_number']; ?></td>
                                <td><?php echo $row['address']; ?></td>
                                <td>
                                    <!-- Edit and Delete buttons -->
                                    <div class="action-buttons">
                                        <a href="edit_user.php?id=<?php echo $row['user_id']; ?>" class="btn edit-btn">Edit</a>
                                        <a href="delete_user.php?id=<?php echo $row['user_id']; ?>" class="btn delete-btn">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </table>
                </div>

                <br>
                <a href="add_user.php" class="btn add-user-btn">Add New User</a>
            </div>
        </div>
    </div>
</body>
</html>
