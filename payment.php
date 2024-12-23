<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include 'config.php';

// Fetch user_id from the database (this should be set based on your application's logic)
$user_id = 13; // Example user_id, replace with actual logic to fetch user_id

// Fetch bookings for the user
$sql = "SELECT b.*, c.status as cargo_status, c.payment_status, p.description as package_description, t.truck_type
        FROM bookings b
        JOIN cargo c ON b.cargo_id = c.cargo_id
        JOIN packages p ON b.package_id = p.package_id
        JOIN truck t ON c.truck_id = t.truck_id
        WHERE b.customer_id = '$user_id'";
$result = mysqli_query($conn, $sql);

// Check for SQL errors
if (!$result) {
    die("Error fetching bookings: " . mysqli_error($conn));
}

// Handle payment and cancellation actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $cargo_id = $_POST['cargo_id'];

    if ($action == "pay") {
        // Update delivery and payment status
        $update_cargo = "UPDATE cargo SET status = 'Delivered', payment_status = 'Paid' WHERE cargo_id = '$cargo_id'";
        $update_report = "UPDATE reports SET delivery_status = 'Delivered', payment_status = 'Paid' WHERE cargo_id = '$cargo_id'";
        $update_package = "UPDATE packages SET status = 'delivered' WHERE package_id = (SELECT package_id FROM cargo WHERE cargo_id = '$cargo_id')";
        
        // Execute queries and check for errors
        if (mysqli_query($conn, $update_cargo) && mysqli_query($conn, $update_report) && mysqli_query($conn, $update_package)) {
            echo "<script>alert('Payment successful. The package has been marked as Delivered.'); window.location.href = 'payment.php';</script>";
        } else {
            echo "<script>alert('Error processing payment: " . mysqli_error($conn) . "');</script>";
            error_log("SQL Error: " . mysqli_error($conn));
        }
    } elseif ($action == "cancel") {
        // Update package status to 'pending'
        $update_package = "UPDATE packages SET status = 'pending' WHERE package_id = (SELECT package_id FROM cargo WHERE cargo_id = '$cargo_id')";
        $update_cargo = "UPDATE cargo SET status = 'Pending' WHERE cargo_id = '$cargo_id'";
        $update_report = "UPDATE reports SET delivery_status = 'Pending' WHERE cargo_id = '$cargo_id'";
        
        // Execute queries and check for errors
        if (mysqli_query($conn, $update_package) && mysqli_query($conn, $update_cargo) && mysqli_query($conn, $update_report)) {
            echo "<script>alert('Package has been cancelled.'); window.location.href = 'payment.php';</script>";
        } else {
            echo "<script>alert('Error cancelling package: " . mysqli_error($conn) . "');</script>";
            error_log("SQL Error: " . mysqli_error($conn));
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
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

        h2 {
            font-size: 20px;
            margin-bottom: 20px;
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

        .btn {
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            margin-right: 5px;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .btn-danger {
            background-color: #f44336;
        }

        .btn-danger:hover {
            background-color: #e53935;
        }
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
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
        <div class="main-content">
            <header>
                <h1>Payment</h1>
                <a href="index.php" class="logout-btn">Logout</a>
            </header>
            <div class="dashboard-main-container">
                <h2>Your Bookings</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Package Description</th>
                            <th>Truck Type</th>
                            <th>Route From</th>
                            <th>Route To</th>
                            <th>Price</th>
                            <th>Delivery Status</th>
                            <th>Payment Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($booking = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $booking['package_description']; ?></td>
                            <td><?php echo $booking['truck_type']; ?></td>
                            <td><?php echo $booking['route_from']; ?></td>
                            <td><?php echo $booking['route_to']; ?></td>
                            <td>$<?php echo number_format($booking['price'], 2); ?></td>
                            <td><?php echo $booking['cargo_status']; ?></td>
                            <td><?php echo $booking['payment_status']; ?></td>
                            <td>
                                <form method="POST" action="" onsubmit="return confirmAction(this);">
                                    <input type="hidden" name="cargo_id" value="<?php echo $booking['cargo_id']; ?>">
                                    <?php if ($booking['cargo_status'] == 'In Transit' && $booking['payment_status'] == 'Unpaid'): ?>
                                        <button type="submit" name="action" value="pay" class="btn">Pay</button>
                                        <button type="submit" name="action" value="cancel" class="btn btn-danger">Cancel</button>
                                    <?php endif; ?>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        function confirmAction(form) {
            const action = form.querySelector('button[type="submit"]:focus').value;
            if (action === 'pay') {
                return confirm('By paying you confirm that the package has been delivered. Are you sure you want to pay?');
            } else if (action === 'cancel') {
                return confirm('Are you sure you want to cancel the package?');
            }
            return false;
        }
    </script>
</body>
</html>
