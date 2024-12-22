<?php
// Include database connection
include 'config.php';

// Check if the cargo ID is provided
if (isset($_GET['id'])) {
    $cargo_id = $_GET['id'];

    // Delete the cargo from the database
    $sql_delete = "DELETE FROM cargo WHERE cargo_id = '$cargo_id'";

    if (mysqli_query($conn, $sql_delete)) {
        header("Location: cargo.php"); // Redirect to cargo list
        exit();
    } else {
        echo "Error: " . $sql_delete . "<br>" . mysqli_error($conn);
    }
} else {
    echo "Invalid cargo ID!";
}
?>
