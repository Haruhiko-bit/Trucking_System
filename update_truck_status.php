<?php
// Include database connection
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $truck_id = $_POST['truck_id'];
    $status = $_POST['status'];

    // Update the status in the truck table
    $query = "UPDATE truck SET status='$status' WHERE truck_id='$truck_id'";
    mysqli_query($conn, $query);

    // Redirect back to the trucks page
    header("Location: driver_trucks.php");
}
?>