<?php
// Include database connection
include 'config.php';

// Check if the form is submitted
if (isset($_POST['update'])) {
    $package_id = $_POST['package_id'];
    $customer_id = $_POST['customer_id'];
    $product_id = $_POST['product_id'];
    $description = $_POST['description']; // Updated from volume to description
    $weight = $_POST['weight'];
    $status = $_POST['status'];

    // Update the package details in the database
    $sql = "UPDATE packages SET customer_id='$customer_id', product_id='$product_id', description='$description', weight='$weight', status='$status' WHERE package_id='$package_id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: package.php?success=Package updated successfully");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Fetch package details to edit
if (isset($_GET['id'])) {
    $package_id = $_GET['id'];
    $sql = "SELECT * FROM packages WHERE package_id='$package_id'";
    $result = mysqli_query($conn, $sql);
    $package = mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Package</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .form-container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        input, select {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
            transition: 0.3s;
        }

        .cancel-btn {
            background-color: #f44336;
            margin-top: 10px;
        }

        .cancel-btn:hover {
            background-color: #e41e15;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Edit Package</h2>
        <form action="" method="POST">
            <input type="hidden" name="package_id" value="<?php echo $package['package_id']; ?>">

            <label for="customer_id">Customer ID</label>
            <input type="text" id="customer_id" name="customer_id" value="<?php echo $package['customer_id']; ?>" required>

            <label for="product_id">Product ID</label>
            <input type="text" id="product_id" name="product_id" value="<?php echo $package['product_id']; ?>" required>

            <label for="description">Description</label> <!-- Updated field -->
            <input type="text" id="description" name="description" value="<?php echo $package['description']; ?>" required> <!-- Updated field -->

            <label for="weight">Weight (kg)</label>
            <input type="text" id="weight" name="weight" value="<?php echo $package['weight']; ?>" required>

            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="Pending" <?php echo ($package['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="in-transit" <?php echo ($package['status'] == 'in-transit') ? 'selected' : ''; ?>>in-transit</option>
                <option value="Delivered" <?php echo ($package['status'] == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
            </select>

            <button type="submit" name="update">Update Package</button>
            <a href="package.php" class="cancel-btn">Cancel</a>
        </form>
    </div>
</body>
</html>
