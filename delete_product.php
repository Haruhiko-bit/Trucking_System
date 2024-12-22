<?php
// Include database connection
include 'config.php';

// Check if the product_id is passed through the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Sanitize the product_id to prevent SQL injection
    $product_id = mysqli_real_escape_string($conn, $product_id);

    // Delete query
    $sql = "DELETE FROM products WHERE product_id = '$product_id'";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Redirect to product page after successful deletion
        header("Location: product.php");
        exit();
    } else {
        // If there's an error, display it
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    // If no product_id is set in the URL, redirect to product page
    header("Location: product.php");
    exit();
}
?>
