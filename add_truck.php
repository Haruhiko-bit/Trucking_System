<?php
// Include database connection
include 'config.php';

// Handle form submission for adding a new truck
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $truck_id = $_POST['truck_id'];
    $license_plate = $_POST['license_plate'];
    $truck_type = $_POST['truck_type'];
    $capacity = $_POST['capacity'];
    $status = $_POST['status'];

    // Check if the truck ID already exists
    $check_sql = "SELECT * FROM truck WHERE truck_id = '$truck_id'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Truck ID already exists!');</script>";
    } else {
        $sql = "INSERT INTO truck (truck_id, license_plate, truck_type, capacity, status) 
                VALUES ('$truck_id', '$license_plate', '$truck_type', '$capacity', '$status')";

        if (mysqli_query($conn, $sql)) {
            header("Location: truck.php");
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Truck</title>
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

        input,
        select {
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
                <h1>Add New Truck</h1>
                <a href="index.php" class="logout-btn">Logout</a>
            </header>

            <div class="dashboard-main-container">
                <h2>Truck Information</h2>

                <!-- Add Truck Form -->
                <form method="POST" action="">
                    <label for="truck_id">Truck ID:</label>
                    <input type="text" id="truck_id" name="truck_id" required>

                    <label for="license_plate">License Plate:</label>
                    <input type="text" id="license_plate" name="license_plate" required>

                    <label for="truck_type">Truck Type:</label>
                    <input type="text" id="truck_type" name="truck_type" required>

                    <label for="capacity">Capacity (in KG):</label>
                    <input type="number" id="capacity" name="capacity" required>

                    <label for="status">Status:</label>
                    <select id="status" name="status" required>
                        <option value="Available">Available</option>
                        <option value="In Use">In Use</option>
                        <option value="Maintenance">Maintenance</option>
                    </select>

                    <input type="submit" value="Add Truck" class="submit-btn">
                </form>
            </div>
        </div>
    </div>
</body>

</html>