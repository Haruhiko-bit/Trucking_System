<?php
// Include database connection
include 'config.php';

// Handle Delete Package
if (isset($_GET['id'])) {
    $package_id = $_GET['id'];

    // Delete package from the database
    $query = "DELETE FROM packages WHERE package_id = '$package_id'";
    mysqli_query($conn, $query);

    // Redirect back to the package list after deletion
    header("Location: package.php");
}
?>
