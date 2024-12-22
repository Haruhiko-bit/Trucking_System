<?php
// Include database connection
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    // Insert into the products table
    $sql = "INSERT INTO products (product_name, description, price, quantity) 
            VALUES ('$product_name', '$description', '$price', '$quantity')";

    if (mysqli_query($conn, $sql)) {
        header("Location: product.php"); // Redirect to product list
        exit();
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
    <title>Add Product</title>

    <!-- Inline CSS -->
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #333;
            color: white;
            padding: 20px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar-links {
            list-style: none;
            padding: 0;
        }

        .sidebar-links li {
            margin: 10px 0;
        }

        .sidebar-btn {
            text-decoration: none;
            color: white;
            display: block;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            background-color: #444;
        }

        .sidebar-btn:hover {
            background-color: #555;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #333;
            color: white;
            padding: 20px;
        }

        header h1 {
            margin: 0;
        }

        .logout-btn {
            color: white;
            text-decoration: none;
            background-color: #d9534f;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .logout-btn:hover {
            background-color: #c9302c;
        }

        .dashboard-main-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }

        .dashboard-main-container form {
            display: flex;
            flex-direction: column;
        }

        .dashboard-main-container label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .dashboard-main-container input,
        .dashboard-main-container textarea,
        .dashboard-main-container select {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .dashboard-main-container input[type="submit"] {
            background-color: #5bc0de;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .dashboard-main-container input[type="submit"]:hover {
            background-color: #31b0d5;
        }

        .dashboard-main-container textarea {
            resize: vertical;
            min-height: 100px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <ul class="sidebar-links">
                <li><a href="admin_dashboard.php" class="sidebar-btn">Dashboard</a></li>
                <li><a href="package.php" class="sidebar-btn">Package</a></li>
                <li><a href="product.php" class="sidebar-btn">Product</a></li>
                <li><a href="cargo.php" class="sidebar-btn">Cargo</a></li>
                <li><a href="truck.php" class="sidebar-btn">Truck</a></li>
                <li><a href="users.php" class="sidebar-btn">Users</a></li>
                <li><a href="reports.php" class="sidebar-btn">Reports</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <header>
                <h1>Add New Product</h1>
                <a href="index.php" class="logout-btn">Logout</a>
            </header>

            <div class="dashboard-main-container">
                <form action="add_product.php" method="POST">
                    <label for="product_name">Product Name:</label><br>
                    <input type="text" id="product_name" name="product_name" required><br><br>

                    <label for="description">Description:</label><br>
                    <textarea id="description" name="description" required></textarea><br><br>

                    <label for="price">Price:</label><br>
                    <input type="number" id="price" name="price" required><br><br>

                    <label for="quantity">Quantity:</label><br>
                    <input type="number" id="quantity" name="quantity" required><br><br>

                    <input type="submit" value="Add Product">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
