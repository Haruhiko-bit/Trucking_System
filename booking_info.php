<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include 'config.php';

// Fetch all bookings for the user
$sql = "SELECT c.*, p.description as package_description, 
        t.truck_type, r.payment_status
        FROM cargo c
        JOIN packages p ON c.package_id = p.package_id
        JOIN truck t ON c.truck_id = t.truck_id
        JOIN reports r ON c.cargo_id = r.cargo_id
        WHERE c.status = 'In Transit' OR c.status = 'Pending'";
$result = mysqli_query($conn, $sql);

// Handle payment and cancellation actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $cargo_id = $_POST['cargo_id'];
    $truck_id = $_POST['truck_id'];
    $package_id = $_POST['package_id'];
    $status = $_POST['status'];
    $payment_status = $_POST['payment_status'];

    if ($action == "pay") {
        // Start transaction
        mysqli_begin_transaction($conn);

        try {
            // Update status to Delivered and payment status to Paid
            $update_cargo = "UPDATE cargo SET status = 'Delivered', payment_status = 'Paid' WHERE cargo_id = '$cargo_id'";
            $update_report = "UPDATE reports SET delivery_status = 'Delivered', payment_status = 'Paid' WHERE cargo_id = '$cargo_id'";
            $update_package = "UPDATE packages SET status = 'delivered' WHERE package_id = '$package_id'";
            $update_truck = "UPDATE truck SET status = 'Available' WHERE truck_id = '$truck_id'";

            if (!mysqli_query($conn, $update_cargo)) {
                throw new Exception("Error updating cargo: " . mysqli_error($conn));
            }
            if (!mysqli_query($conn, $update_report)) {
                throw new Exception("Error updating report: " . mysqli_error($conn));
            }
            if (!mysqli_query($conn, $update_package)) {
                throw new Exception("Error updating package: " . mysqli_error($conn));
            }
            if (!mysqli_query($conn, $update_truck)) {
                throw new Exception("Error updating truck: " . mysqli_error($conn));
            }

            // Commit transaction
            mysqli_commit($conn);

            echo "<script>alert('Payment successful. The package has been marked as Delivered.'); window.location.href = 'booking_info.php';</script>";
        } catch (Exception $e) {
            // Rollback transaction
            mysqli_rollback($conn);
            echo "<script>alert('Error processing payment: " . $e->getMessage() . "');</script>";
        }
    } elseif ($action == "cancel") {
        // Start transaction
        mysqli_begin_transaction($conn);

        try {
            // Update status to Pending
            $update_cargo = "UPDATE cargo SET status = 'Pending' WHERE cargo_id = '$cargo_id'";
            $update_report = "UPDATE reports SET delivery_status = 'Pending' WHERE cargo_id = '$cargo_id'";
            $update_package = "UPDATE packages SET status = 'pending' WHERE package_id = '$package_id'";
            $update_truck = "UPDATE truck SET status = 'Available' WHERE truck_id = '$truck_id'";

            if (!mysqli_query($conn, $update_cargo)) {
                throw new Exception("Error updating cargo: " . mysqli_error($conn));
            }
            if (!mysqli_query($conn, $update_report)) {
                throw new Exception("Error updating report: " . mysqli_error($conn));
            }
            if (!mysqli_query($conn, $update_package)) {
                throw new Exception("Error updating package: " . mysqli_error($conn));
            }
            if (!mysqli_query($conn, $update_truck)) {
                throw new Exception("Error updating truck: " . mysqli_error($conn));
            }

            // Commit transaction
            mysqli_commit($conn);

            echo "<script>alert('Package has been cancelled.'); window.location.href = 'booking_info.php';</script>";
        } catch (Exception $e) {
            // Rollback transaction
            mysqli_rollback($conn);
            echo "<script>alert('Error cancelling package: " . $e->getMessage() . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Information</title>
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
        .dashboard-main-container { background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        h2 { font-size: 20px; margin-bottom: 20px; }
        .info-box { padding: 15px; border: 1px solid #ddd; border-radius: 5px; margin-bottom: 20px; }
        .info-box table { width: 100%; border-collapse: collapse; }
        .info-box th, .info-box td { padding: 12px; border: 1px solid #ddd; }
        .info-box th { background-color: #f4f4f4; }
        .info-box td { background-color: #fff; }
        .btn { padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; text-align: center; display: inline-block; margin-right: 10px; }
        .btn:hover { background-color: #45a049; }
        .btn-danger { background-color: #f44336; }
        .btn-danger:hover { background-color: #e53935; }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <h2>Customer Dashboard</h2>
            <ul class="sidebar-links">
                <li><a href="customer_dashboard.php">Dashboard</a></li>
                <li><a href="booking.php">Booking</a></li>
                <li><a href="payment.php">Payment</a></li>
            </ul>
        </div>
        <div class="main-content">
            <header>
                <h1>Booking Information</h1>
            </header>
            <div class="dashboard-main-container">
                <h2>Your Bookings</h2>
                <?php while ($booking = mysqli_fetch_assoc($result)): ?>
                    <div class="info-box">
                        <table>
                            <tr>
                                <th>Cargo ID</th>
                                <td><?php echo htmlspecialchars($booking['cargo_id']); ?></td>
                            </tr>
                            <tr>
                                <th>Truck ID</th>
                                <td><?php echo htmlspecialchars($booking['truck_id']); ?> (<?php echo htmlspecialchars($booking['truck_type']); ?>)</td>
                            </tr>
                            <tr>
                                <th>Route From</th>
                                <td><?php echo htmlspecialchars($booking['route_from']); ?></td>
                            </tr>
                            <tr>
                                <th>Route To</th>
                                <td><?php echo htmlspecialchars($booking['route_to']); ?></td>
                            </tr>
                            <tr>
                                <th>Package ID</th>
                                <td><?php echo htmlspecialchars($booking['package_id']); ?> (<?php echo htmlspecialchars($booking['package_description']); ?>)</td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td>$<?php echo htmlspecialchars(number_format((float)$booking['price'], 2)); ?></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td><?php echo htmlspecialchars($booking['status']); ?></td>
                            </tr>
                            <tr>
                                <th>Payment Status</th>
                                <td><?php echo htmlspecialchars($booking['payment_status']); ?></td>
                            </tr>
                        </table>

                        <?php if ($booking['payment_status'] !== 'Paid'): ?>
                            <form method="POST" action="">
                                <input type="hidden" name="cargo_id" value="<?php echo $booking['cargo_id']; ?>">
                                <input type="hidden" name="truck_id" value="<?php echo $booking['truck_id']; ?>">
                                <input type="hidden" name="route_from" value="<?php echo $booking['route_from']; ?>">
                                <input type="hidden" name="route_to" value="<?php echo $booking['route_to']; ?>">
                                <input type="hidden" name="package_id" value="<?php echo $booking['package_id']; ?>">
                                <input type="hidden" name="price" value="<?php echo $booking['price']; ?>">
                                <input type="hidden" name="status" value="<?php echo $booking['status']; ?>">
                                <input type="hidden" name="payment_status" value="<?php echo $booking['payment_status']; ?>">
                                <button type="submit" name="action" value="pay" class="btn" onclick="return confirm('By paying you confirm that the package has been delivered. Are you sure you want to pay?');">Pay</button>
                                <button type="submit" name="action" value="cancel" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel the package?');">Cancel</button>
                            </form>
                        <?php else: ?>
                            <p><strong>Paid</strong></p>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</body>
</html>