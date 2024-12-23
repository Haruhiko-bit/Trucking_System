<?php
// Include database connection
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cargo_id = $_POST['cargo_id'];
    $status = $_POST['status'];

    // Update the status in the cargo table
    $query = "UPDATE cargo SET status='$status' WHERE cargo_id='$cargo_id'";
    mysqli_query($conn, $query);

    // Also update the status in the reports table
    $query = "UPDATE reports SET delivery_status='$status' WHERE cargo_id='$cargo_id'";
    mysqli_query($conn, $query);

    // Redirect back to the driver tasks page
    header("Location: driver_tasks.php");
}
?>