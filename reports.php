<?php 
// Include database connection
include 'config.php';

// Fetch reports from the database
$sql = "SELECT r.*, p.description as package_description, t.driver_id as truck_driver_id
        FROM reports r
        JOIN cargo c ON r.cargo_id = c.cargo_id
        JOIN packages p ON c.package_id = p.package_id
        JOIN truck t ON c.truck_id = t.truck_id";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
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
            background-color: #333;
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

        /* Button Styles */
        .btn {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .edit-btn {
            background-color: #008CBA;
        }

        .edit-btn:hover {
            background-color: #007bb5;
        }

        .delete-btn {
            background-color: #f44336;
        }

        .delete-btn:hover {
            background-color: #e41e15;
        }

        .add-user-btn {
            background-color: #4CAF50;
        }

        .add-user-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <ul class="sidebar-links">
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="package.php">Package</a></li>
                <li><a href="product.php">Product</a></li>
                <li><a href="cargo.php">Cargo</a></li>
                <li><a href="truck.php">Truck</a></li>
                <li><a href="users.php">Users</a></li>
                <li><a href="reports.php">Reports</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Reports</h1>
                <a href="index.php" class="logout-btn">Logout</a>
            </header>

            <div class="dashboard-main-container">
                <h2>Reports Overview</h2>

                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Truck ID</th>
                                <th>Driver ID</th>
                                <th>Route From</th>
                                <th>Route To</th>
                                <th>Package Description</th>
                                <th>Price</th>
                                <th>Delivery Status</th>
                                <th>Payment Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?php echo $row['truck_id']; ?></td>
                                    <td><?php echo $row['truck_driver_id']; ?></td>
                                    <td><?php echo $row['route_from']; ?></td>
                                    <td><?php echo $row['route_to']; ?></td>
                                    <td><?php echo $row['package_description']; ?></td>
                                    <td>$<?php echo number_format($row['price'], 2); ?></td>
                                    <td><?php echo $row['delivery_status']; ?></td>
                                    <td><?php echo $row['payment_status']; ?></td>
                                    <td>
                                        <a href="edit_report.php?id=<?php echo $row['report_id']; ?>" class="btn edit-btn">Edit</a>
                                        <a href="delete_report.php?id=<?php echo $row['report_id']; ?>" class="btn delete-btn">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <a href="add_report.php" class="btn add-user-btn">Add New Report</a>
            </div>
        </div>
    </div>
</body>
</html>
