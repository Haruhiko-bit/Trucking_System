<?php
// Include database connection
include 'config.php';

// Get truck ID from the URL
$truck_id = $_GET['id'];

// Fetch truck details from the database
$sql = "SELECT * FROM truck WHERE truck_id = $truck_id";
$result = mysqli_query($conn, $sql);
$truck = mysqli_fetch_assoc($result);

// Handle form submission for editing the truck
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $license_plate = $_POST['license_plate'];
    $truck_type = $_POST['truck_type'];
    $capacity = $_POST['capacity'];
    $status = $_POST['status'];

    $update_sql = "UPDATE truck SET license_plate = '$license_plate', truck_type = '$truck_type', 
                   capacity = '$capacity', status = '$status' WHERE truck_id = $truck_id";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: truck.php");
    } else {
        echo "Error: " . $update_sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Truck</title>
    <style>
        /* Include common styles here */
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

        /* Form Styles */
        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 10px 0;
            font-size: 16px;
        }

        input, select {
            padding: 10px;
            margin-bottom: 15px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .submit-btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .submit-btn:hover {
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
                <h1>Edit Truck</h1>
                <a href="index.php" class="logout-btn">Logout</a>
            </header>

            <div class="dashboard-main-container">
                <h2>Edit Truck Information</h2>

                <!-- Edit Truck Form -->
                <form method="POST" action="">
                    <label for="license_plate">License Plate:</label>
                    <input type="text" id="license_plate" name="license_plate" value="<?php echo $truck['license_plate']; ?>" required>

                    <label for="truck_type">Truck Type:</label>
                    <input type="text" id="truck_type" name="truck_type" value="<?php echo $truck['truck_type']; ?>" required>

                    <label for="capacity">Capacity (in KG):</label>
                    <input type="number" id="capacity" name="capacity" value="<?php echo $truck['capacity']; ?>" required>

                    <label for="status">Status:</label>
                    <select id="status" name="status" required>
                        <option value="Available" <?php echo $truck['status'] == 'Available' ? 'selected' : ''; ?>>Available</option>
                        <option value="In Use" <?php echo $truck['status'] == 'In Use' ? 'selected' : ''; ?>>In Use</option>
                        <option value="Maintenance" <?php echo $truck['status'] == 'Maintenance' ? 'selected' : ''; ?>>Maintenance</option>
                    </select>

                    <input type="submit" value="Update Truck" class="submit-btn">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
