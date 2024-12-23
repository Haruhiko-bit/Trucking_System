<?php
// Include database connection
include 'config.php';

// Check if report ID is provided
if (isset($_GET['id'])) {
    $report_id = $_GET['id'];

    // Fetch report details
    $sql = "SELECT * FROM reports WHERE report_id = $report_id";
    $result = mysqli_query($conn, $sql);
    $report = mysqli_fetch_assoc($result);

    if (!$report) {
        echo "<script>alert('Report not found!'); window.location.href = 'reports.php';</script>";
        exit;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $truck_id = $_POST['truck_id'];
    $driver_id = $_POST['driver_id'];
    $route_from = $_POST['route_from'];
    $route_to = $_POST['route_to'];
    $package_volume = $_POST['package_volume'];
    $price = $_POST['price'];
    $delivery_status = $_POST['delivery_status'];
    $payment_status = $_POST['payment_status'];

    // Update the report
    $update_sql = "UPDATE reports 
                   SET truck_id = '$truck_id', driver_id = '$driver_id', route_from = '$route_from', route_to = '$route_to', 
                       package_volume = '$package_volume', price = '$price', delivery_status = '$delivery_status', 
                       payment_status = '$payment_status'
                   WHERE report_id = $report_id";
    if (mysqli_query($conn, $update_sql)) {
        echo "<script>alert('Report updated successfully!'); window.location.href = 'reports.php';</script>";
    } else {
        echo "<script>alert('Error updating report: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Report</title>
    <style>
        /* Inline styles for form */
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .form-container { max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h2 { text-align: center; margin-bottom: 20px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input, select { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; }
        button { width: 100%; padding: 10px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #45a049; }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Report</h2>
        <form method="POST">
            <label for="truck_id">Truck ID</label>
            <input type="text" name="truck_id" value="<?php echo $report['truck_id']; ?>" required>

            <label for="driver_id">Driver ID</label>
            <input type="text" name="driver_id" value="<?php echo $report['driver_id']; ?>" required>

            <label for="route_from">Route From</label>
            <input type="text" name="route_from" value="<?php echo $report['route_from']; ?>" required>

            <label for="route_to">Route To</label>
            <input type="text" name="route_to" value="<?php echo $report['route_to']; ?>" required>

            <label for="package_volume">Package Volume</label>
            <input type="text" name="package_volume" value="<?php echo $report['package_volume']; ?>" required>

            <label for="price">Price</label>
            <input type="text" name="price" value="<?php echo $report['price']; ?>" required>

            <label for="delivery_status">Delivery Status</label>
            <select name="delivery_status" required>
                <option value="In Transit" <?php echo $report['delivery_status'] === 'In Transit' ? 'selected' : ''; ?>>In Transit</option>
                <option value="Delivered" <?php echo $report['delivery_status'] === 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
            </select>

            <label for="payment_status">Payment Status</label>
            <select name="payment_status" required>
                <option value="Paid" <?php echo $report['payment_status'] === 'Paid' ? 'selected' : ''; ?>>Paid</option>
                <option value="Unpaid" <?php echo $report['payment_status'] === 'Unpaid' ? 'selected' : ''; ?>>Unpaid</option>
            </select>

            <button type="submit">Update Report</button>
        </form>
    </div>
</body>
</html>