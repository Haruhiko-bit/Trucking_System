<?php
// Enable error reporting for debugging (to see any issues with the connection)
ini_set('display_errors', 1);  
error_reporting(E_ALL);

// Database connection details
$servername = "sql206.byethost7.com"; // Replace with your server name
$username = "b7_37365160"; // Replace with your database username
$password = "Harukora1125Mojeckjeck."; // Replace with your database password
$dbname = "b7_37365160_truck_management_system"; // Your database name

// Attempt to connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);  // If connection fails, display error and stop execution
}

// If the connection is successful, you can use the $conn variable to query the database


?>
