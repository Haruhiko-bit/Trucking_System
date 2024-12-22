<?php
// Include database connection
include 'config.php';

// Define route prices (example: Route 1 to Route 20)
$route_prices = array(
    1 => 50, 2 => 100, 3 => 150, 4 => 200, 5 => 250,
    6 => 300, 7 => 350, 8 => 400, 9 => 450, 10 => 500,
    11 => 600, 12 => 700, 13 => 800, 14 => 900, 15 => 1000,
    16 => 1100, 17 => 1200, 18 => 1300, 19 => 1400, 20 => 1500,
);

// Function to calculate price based on route difference
function calculate_price($route_from, $route_to, $prices) {
    $distance = abs($route_to - $route_from);
    return isset($prices[$distance]) ? $prices[$distance] : 0;
}

// Update truck status based on delivery status
function update_truck_status($conn, $truck_id, $delivery_status) {
    $truck_status = ($delivery_status == 'In Transit') ? 'In Use' : (($delivery_status == 'Delivered') ? 'Available' : null);
    if ($truck_status) {
        $sql = "UPDATE truck SET status = '$truck_status' WHERE truck_id = '$truck_id'";
        mysqli_query($conn, $sql);
    }
}

// Sync cargo updates with reports
function sync_cargo_to_reports($conn, $cargo_id, $delivery_status, $payment_status) {
    // Update delivery_status and payment_status in the reports table
    $sql = "UPDATE reports 
            SET delivery_status = '$delivery_status', 
                payment_status = '$payment_status' 
            WHERE cargo_id = '$cargo_id'";
    mysqli_query($conn, $sql);
}

// Fetch cargo records from the database
$sql = "SELECT c.*, p.description as package_description 
        FROM cargo c
        JOIN packages p ON c.cargo_id = p.package_id";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargo List</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        .dashboard-container { display: flex; height: 100vh; }
        .sidebar { width: 220px; background-color: #333; color: white; padding-top: 20px; }
        .sidebar h2 { text-align: center; margin-bottom: 30px; }
        .sidebar-links { list-style: none; padding: 0; margin: 0; }
        .sidebar-links li { padding: 15px; text-align: center; }
        .sidebar-links li a { color: white; text-decoration: none; display: block; font-size: 16px; }
        .sidebar-links li a:hover { background-color: #444; transition: 0.3s; }
        .main-content { flex-grow: 1; padding: 20px; }
        header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        header h1 { font-size: 24px; }
        .logout-btn { padding: 10px 20px; background-color: #ff5722; color: white; text-decoration: none; border-radius: 5px; }
        .logout-btn:hover { background-color: #e64a19; transition: 0.3s; }
        .dashboard-main-container { background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        h2 { font-size: 20px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table th, table td { padding: 12px; border: 1px solid #ddd; text-align: center; }
        table th { background-color: #f4f4f4; }
        table td { background-color: #fff; }
        .btn { padding: 8px 16px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; margin-right: 5px; }
        .btn:hover { background-color: #45a049; }
        .btn-danger { background-color: #f44336; }
        .btn-danger:hover { background-color: #e53935; }
        .add-cargo-btn { padding: 10px 20px; background-color: #2196F3; color: white; text-decoration: none; border-radius: 5px; margin-bottom: 20px; display: inline-block; }
        .add-cargo-btn:hover { background-color: #1976D2; transition: 0.3s; }
    </style>
</head>
<body>
    <div class="dashboard-container">
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
        <div class="main-content">
            <header>
                <h1>Cargo List</h1>
                <a href="index.php" class="logout-btn">Logout</a>
            </header>
            <div class="dashboard-main-container">
                <h2>All Cargo Entries</h2>
                <a href="add_cargo.php" class="add-cargo-btn">Add Cargo</a>
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
                        <?php while ($cargo = mysqli_fetch_assoc($result)): 
                            $price = calculate_price($cargo['route_from'], $cargo['route_to'], $route_prices);
                            update_truck_status($conn, $cargo['truck_id'], $cargo['status']);
                            sync_cargo_to_reports($conn, $cargo['cargo_id'], $cargo['status'], $cargo['payment_status']);
                        ?>
                        <tr>
                            <td><?php echo $cargo['truck_id']; ?></td>
                            <td><?php echo $cargo['driver_id']; ?></td>
                            <td><?php echo $cargo['route_from']; ?></td>
                            <td><?php echo $cargo['route_to']; ?></td>
                            <td><?php echo $cargo['package_description']; ?></td>
                            <td>$<?php echo number_format($price, 2); ?></td>
                            <td><?php echo $cargo['status']; ?></td>
                            <td><?php echo $cargo['payment_status']; ?></td>
                            <td>
                                <a href="edit_cargo.php?id=<?php echo $cargo['cargo_id']; ?>" class="btn">Edit</a>
                                <a href="delete_cargo.php?id=<?php echo $cargo['cargo_id']; ?>" class="btn btn-danger">Delete</a>
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
