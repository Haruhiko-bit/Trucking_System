<?php
// Include database connection
include 'config.php';

// Define route prices (example: Route 1 to Route 20)
$route_prices = array(
    1 => 50,
    2 => 100,
    3 => 150,
    4 => 200,
    5 => 250,
    6 => 300,
    7 => 350,
    8 => 400,
    9 => 450,
    10 => 500,
    11 => 600,
    12 => 700,
    13 => 800,
    14 => 900,
    15 => 1000,
    16 => 1100,
    17 => 1200,
    18 => 1300,
    19 => 1400,
    20 => 1500,
);

// Function to calculate price based on route difference
function calculate_price($route_from, $route_to, $prices) {
    $distance = abs($route_to - $route_from);
    return isset($prices[$distance]) ? $prices[$distance] : 0;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $truck_id = $_POST['truck_id'];
    $driver_id = $_POST['driver_id'];
    $route_from = $_POST['route_from'];
    $route_to = $_POST['route_to'];
    $package_volume = $_POST['package_volume'];
    $price = calculate_price($route_from, $route_to, $route_prices);
    $delivery_status = 'In Transit';
    $payment_status = $_POST['payment_status'];

    // Check truck availability
    $truck_query = "SELECT status FROM truck WHERE truck_id = '$truck_id'";
    $truck_result = mysqli_query($conn, $truck_query);
    $truck = mysqli_fetch_assoc($truck_result);

    if (!$truck || $truck['status'] != 'Available') {
        echo "<script>alert('That truck is not available.');</script>";
    } else {
        // Insert new cargo record
        $sql = "INSERT INTO cargo (truck_id, driver_id, route_from, route_to, package_volume, price, status, payment_status)
                VALUES ('$truck_id', '$driver_id', '$route_from', '$route_to', '$package_volume', '$price', '$delivery_status', '$payment_status')";
        if (mysqli_query($conn, $sql)) {
            // Update truck status to "In Use"
            $update_truck = "UPDATE truck SET status = 'In Use' WHERE truck_id = '$truck_id'";
            mysqli_query($conn, $update_truck);
            
            // Insert report data into the reports table
            $insert_report = "INSERT INTO reports (truck_id, driver_id, route_from, route_to, package_volume, price, delivery_status, payment_status)
                              VALUES ('$truck_id', '$driver_id', '$route_from', '$route_to', '$package_volume', '$price', '$delivery_status', '$payment_status')";
            mysqli_query($conn, $insert_report);

            echo "<script>alert('Cargo added and report created successfully.'); window.location.href = 'cargo.php';</script>";
        } else {
            echo "<script>alert('Error adding cargo: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Cargo</title>
    <style>
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

        form {
            max-width: 600px;
            margin: 0 auto;
            display: grid;
            gap: 15px;
        }

        label {
            font-weight: bold;
            display: block;
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            display: block;
            width: 100%;
        }

        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
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
        <div class="main-content">
            <header>
                <h1>Add Cargo</h1>
                <a href="index.php" class="logout-btn">Logout</a>
            </header>
            <div class="dashboard-main-container">
                <form method="POST" action="">
                    <label for="truck_id">Truck ID</label>
                    <select name="truck_id" required>
                        <option value="">Select a Truck</option>
                        <?php
                        $trucks_query = "SELECT truck_id FROM truck WHERE status = 'Available'";
                        $trucks_result = mysqli_query($conn, $trucks_query);
                        while ($truck = mysqli_fetch_assoc($trucks_result)) {
                            echo "<option value='{$truck['truck_id']}'>{$truck['truck_id']}</option>";
                        }
                        ?>
                    </select>

                    <label for="driver_id">Driver ID</label>
                    <input type="text" name="driver_id" required>

                    <label for="route_from">Route From</label>
                    <select name="route_from" required>
                        <option value="">Select a Route</option>
                        <?php for ($i = 1; $i <= 20; $i++) {
                            echo "<option value='$i'>Route $i</option>";
                        } ?>
                    </select>

                    <label for="route_to">Route To</label>
                    <select name="route_to" required>
                        <option value="">Select a Route</option>
                        <?php for ($i = 1; $i <= 20; $i++) {
                            echo "<option value='$i'>Route $i</option>";
                        } ?>
                    </select>

                    <label for="package_volume">Package Volume</label>
                    <input type="text" name="package_volume" required>

                    <label for="payment_status">Payment Status</label>
                    <select name="payment_status" required>
                        <option value="Paid">Paid</option>
                        <option value="Unpaid">Unpaid</option>
                    </select>

                    <button type="submit" class="btn">Add Cargo</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
