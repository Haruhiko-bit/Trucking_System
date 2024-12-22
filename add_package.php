<?php
// Include database connection
include 'config.php';

// Insert package logic (if form submitted)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_id = $_POST['customer_id'];
    $product_id = $_POST['product_id'];
    $volume = $_POST['volume'];
    $weight = $_POST['weight'];
    $status = $_POST['status'];

    // Insert query
    $sql = "INSERT INTO packages (customer_id, product_id, volume, weight, status) 
            VALUES ('$customer_id', '$product_id', '$volume', '$weight', '$status')";
    
    if (mysqli_query($conn, $sql)) {
        echo "New package added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Package</title>
    <style>
        /* Inline the style for consistency */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .form-container {
            width: 50%;
            margin: auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .sidebar {
            display: none;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add Package</h2>
        <form method="POST" action="">
            <label for="customer_id">Customer ID</label>
            <input type="text" id="customer_id" name="customer_id" required>

            <label for="product_id">Product ID</label>
            <input type="text" id="product_id" name="product_id" required>

            <label for="volume">Volume</label>
            <input type="number" step="0.01" id="volume" name="volume" required>

            <label for="weight">Weight</label>
            <input type="number" step="0.01" id="weight" name="weight" required>

            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="pending">Pending</option>
                <option value="in-transit">In-Transit</option>
                <option value="delivered">Delivered</option>
            </select>

            <button type="submit" class="btn">Add Package</button>
        </form>
    </div>
</body>
</html>
