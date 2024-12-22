<?php
include 'config.php';

// Fetch form data
$route_id = $_POST['route_id'];
$goods_type = $_POST['goods_type'];
$weight = $_POST['weight'];
$price = $_POST['price'];

// Assume customer_id is stored in the session (if using a session-based login)
$customer_id = 1; // This is just for the example, replace with actual session-based customer_id

// Insert booking into the database
$sql = "INSERT INTO bookings (customer_id, route_id, goods_type, weight, price) 
        VALUES ('$customer_id', '$route_id', '$goods_type', '$weight', '$price')";

if (mysqli_query($conn, $sql)) {
    echo "Booking successfully placed!";
    // Redirect to the bookings page (or show confirmation)
    header("Location: bookings.php");
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
