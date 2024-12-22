<?php
// Include database connection
include 'config.php';

if (isset($_GET['id'])) {
    $truck_id = $_GET['id'];

    // Delete the truck from the database
    $sql = "DELETE FROM truck WHERE truck_id = '$truck_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: truck.php"); // Redirect to the truck list page
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    echo "Truck not found!";
    exit();
}
?>
