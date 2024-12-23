<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard</title>
    <style>
        /* Inline CSS for Driver Dashboard */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .dashboard-container {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 220px;
            background-color: #333;
            color: white;
            padding-top: 20px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-links li {
            padding: 15px;
            text-align: center;
        }

        .sidebar-links li a {
            color: white;
            text-decoration: none;
            display: block;
            font-size: 16px;
        }

        .sidebar-links li a:hover {
            background-color: #444;
            transition: 0.3s;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        header h1 {
            font-size: 24px;
        }

        .logout-btn {
            padding: 10px 20px;
            background-color: #ff5722;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .logout-btn:hover {
            background-color: #e64a19;
            transition: 0.3s;
        }

        .dashboard-main-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <h2>Driver Dashboard</h2>
            <ul class="sidebar-links">
                <li><a href="driver_dashboard.php" class="sidebar-btn">Dashboard</a></li>
                <li><a href="driver_tasks.php" class="sidebar-btn">My Tasks</a></li>
                <li><a href="driver_trucks.php" class="sidebar-btn">Available Trucks</a></li>
                <li><a href="index.php" class="logout-btn">Logout</a></li>
            </ul>
        </div>
        <div class="main-content">
            <header>
                <h1>
                    <?php
                    // Include database connection
                    include 'config.php';
                    session_start();
                    $user_id = $_SESSION['user_id'];
                    $query = "SELECT username FROM users WHERE user_id = '$user_id'";
                    $result = mysqli_query($conn, $query);
                    if ($user = mysqli_fetch_assoc($result)) {
                        echo "Welcome, " . htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8');
                    } else {
                        echo "Welcome, Driver";
                    }
                    ?>
                </h1>
                <a href="index.php" class="logout-btn">Logout</a>
            </header>
            <div class="dashboard-main-container">
                <h2>Welcome to the Driver Dashboard</h2>
                <p>Use the sidebar to navigate to your tasks or view available trucks.</p>
            </div>
        </div>
    </div>
</body>
</html>