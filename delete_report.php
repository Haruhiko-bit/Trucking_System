<?php
// Include database connection
include 'config.php';

// Check if report ID is provided
if (isset($_GET['id'])) {
    $report_id = $_GET['id'];

    // Delete the report
    $sql = "DELETE FROM reports WHERE report_id = $report_id";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Report deleted successfully!'); window.location.href = 'reports.php';</script>";
    } else {
        echo "<script>alert('Error deleting report: " . mysqli_error($conn) . "'); window.location.href = 'reports.php';</script>";
    }
} else {
    echo "<script>alert('No report ID provided!'); window.location.href = 'reports.php';</script>";
}
?>
