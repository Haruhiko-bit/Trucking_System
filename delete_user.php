<?php
// Include database connection
include 'config.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Delete user from database
    $sql = "DELETE FROM users WHERE user_id = '$user_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: users.php"); // Redirect to users list
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
