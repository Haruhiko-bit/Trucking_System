<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Tasks</title>
    <style>
        /* Inline CSS for Driver Tasks */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        table th {
            background-color: #f4f4f4;
        }

        table td {
            background-color: #fff;
        }

        select, button {
            padding: 10px;
            margin: 5px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <h2>Driver Dashboard</h2>
            <ul class="sidebar-links">
                <li><a href="driver_dashboard.php" class="sidebar-btn">Dashboard</a></li>
                <li><a href="driver_tasks.php" class="sidebar-btn">My Tasks</a></li>
                <li><a href="driver_trucks.php" class="sidebar-btn">Available Trucks</a></li>
                <li><a href="index.php" class="logout-btn">Logout</a></li>
            </ul>
        </div>
        <div class="main-content">
            <header>
                <h1>My Tasks</h1>
                <a href="index.php" class="logout-btn">Logout</a>
            </header>
            <div class="dashboard-main-container">
                <h2>Assigned Tasks</h2>
                <?php
                // Include database connection
                include 'config.php';

                // Fetch driver tasks
                $driver_id = 1; // Replace with dynamic driver ID if needed
                $query = "SELECT c.*, p.description as package_description
                          FROM cargo c
                          JOIN packages p ON c.package_id = p.package_id
                          WHERE c.driver_id = '$driver_id'";
                $result = mysqli_query($conn, $query);
                ?>
                <table>
                    <thead>
                        <tr>
                            <th>Truck ID</th>
                            <th>Route From</th>
                            <th>Route To</th>
                            <th>Package Description</th>
                            <th>Status</th>
                            <th>Update Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($task = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $task['truck_id']; ?></td>
                            <td><?php echo $task['route_from']; ?></td>
                            <td><?php echo $task['route_to']; ?></td>
                            <td><?php echo $task['package_description']; ?></td>
                            <td><?php echo $task['status']; ?></td>
                            <td>
                                <form method="POST" action="update_status.php">
                                    <input type="hidden" name="cargo_id" value="<?php echo $task['cargo_id']; ?>">
                                    <select name="status">
                                        <option value="In Transit" <?php if ($task['status'] == 'In Transit') echo 'selected'; ?>>In Transit</option>
                                        <option value="Delivered" <?php if ($task['status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                                    </select>
                                    <button type="submit">Update</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>