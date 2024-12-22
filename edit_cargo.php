<?php
// Include configuration file
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

// Fetch cargo details
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM cargo WHERE cargo_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $cargo = $result->fetch_assoc();

    if (!$cargo) {
        echo "Cargo record not found!";
        exit;
    }
} else {
    header("Location: cargo.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $truck_id = $_POST['truck_id'];
    $driver_id = $_POST['driver_id'];
    $route_from = $_POST['route_from'];
    $route_to = $_POST['route_to'];
    $package_volume = $_POST['package_volume'];
    $status = $_POST['status'];
    $payment_status = $_POST['payment_status'];

    // Calculate the price
    $price = calculate_price($route_from, $route_to, $route_prices);

    // Update truck status based on delivery status
    $truck_status = ($status === 'In Transit') ? 'In Use' : (($status === 'Delivered') ? 'Available' : null);
    if ($truck_status) {
        $update_truck = "UPDATE truck SET status = ? WHERE truck_id = ?";
        $stmt = $conn->prepare($update_truck);
        $stmt->bind_param("si", $truck_status, $truck_id);
        $stmt->execute();
    }

    // Update cargo details
    $update_query = "UPDATE cargo SET truck_id = ?, driver_id = ?, route_from = ?, route_to = ?, package_volume = ?, price = ?, status = ?, payment_status = ? WHERE cargo_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("iisisdssi", $truck_id, $driver_id, $route_from, $route_to, $package_volume, $price, $status, $payment_status, $id);

    if ($stmt->execute()) {
        // Redirect to cargo list
        header("Location: cargo.php?success=1");
        exit();
    } else {
        $error = "Failed to update cargo details.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Cargo</title>
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
                <h1>Edit Cargo</h1>
            </header>
            <div class="dashboard-main-container">
                <h2>Edit Cargo Details</h2>
                <?php if (isset($error)): ?>
                    <div class="error" style="color: red;"><?php echo $error; ?></div>
                <?php endif; ?>
                <form action="" method="POST">
                    <label for="truck_id">Truck ID:</label>
                    <input type="text" name="truck_id" id="truck_id" value="<?php echo htmlspecialchars($cargo['truck_id']); ?>" required>

                    <label for="driver_id">Driver ID:</label>
                    <input type="text" name="driver_id" id="driver_id" value="<?php echo htmlspecialchars($cargo['driver_id']); ?>" required>

                    <label for="route_from">Route From:</label>
                    <select name="route_from" id="route_from" required>
                        <?php for ($i = 1; $i <= 20; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php echo $cargo['route_from'] == $i ? 'selected' : ''; ?>>Route <?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>

                    <label for="route_to">Route To:</label>
                    <select name="route_to" id="route_to" required>
                        <?php for ($i = 1; $i <= 20; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php echo $cargo['route_to'] == $i ? 'selected' : ''; ?>>Route <?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>

                    <label for="package_volume">Package Volume:</label>
                    <input type="number" name="package_volume" id="package_volume" value="<?php echo htmlspecialchars($cargo['package_volume']); ?>" required>

                    <label for="status">Delivery Status:</label>
                    <select name="status" id="status" required>
                        <option value="In Transit" <?php echo $cargo['status'] == 'In Transit' ? 'selected' : ''; ?>>In Transit</option>
                        <option value="Delivered" <?php echo $cargo['status'] == 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                    </select>

                    <label for="payment_status">Payment Status:</label>
                    <select name="payment_status" id="payment_status" required>
                        <option value="Paid" <?php echo $cargo['payment_status'] == 'Paid' ? 'selected' : ''; ?>>Paid</option>
                        <option value="Unpaid" <?php echo $cargo['payment_status'] == 'Unpaid' ? 'selected' : ''; ?>>Unpaid</option>
                    </select>

                    <button type="submit" class="btn">Update Cargo</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
