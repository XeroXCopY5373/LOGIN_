<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Dummy path for profile picture. Replace this with actual path or URL
$profilePic = 'asset/user.finall.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            background-color: #f5f5f5;
        }
        .header {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 15px 25px;
            background-color: #c3d4e4;

            color: #ecf0f1;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header .user-profile {
            display: flex;
            align-items: center;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 20px;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 500px; /* Adjust width if needed */
            cursor: pointer; /* Show pointer cursor */
        }
        .header .user-profile img {
            border-radius: 50%;
            width: 60px;
            height: 60px;
            object-fit: cover;
            margin-right: 15px;
        }
        .header .user-profile p {
            margin: 0;
            font-size: 1.1em;
            color: #333;
            font-weight: bold;
            display: none; /* Hide username initially */
        }
        .sidebar {
            width: 260px;
            background-color: #c3d4e4;

            color: #ecf0f1;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            box-shadow: 3px 0 6px rgba(0, 0, 0, 0.1);
            border-right: 3px solid #e6e9e7;
            position: fixed;
            height: 100%;
            top: 0;
            overflow-y: auto;
        }
        .sidebar .logo {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .sidebar .logo img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }
        .sidebar h2 {
            margin: 0 0 20px;
            font-size: 1.5em;
            color: #ecf0f1;
        }
        .sidebar a {
            color: #333;
            text-decoration: none;
            display: flex;
            align-items: center;
            margin: 10px 0;
            font-size: 1.1em;
            padding: 10px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            text-align: left;
            transition: background-color 0.3s;
        }
        .sidebar a:hover {
            background-color: #34495e;
            padding-left: 15px;
        }
        .sidebar a i {
            margin-right: 12px;
        }
        .logout-button {
            display: inline-block;
            width: calc(100% - 20px);
            padding: 12px;
            background-color: #e74c3c;
            color: #ecf0f1;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 20px;
            text-align: center;
        }
        .logout-button:hover {
            background-color: #c0392b;
        }
        .main-content {
            flex: 1;
            padding: 20px;
            margin-left: 270px;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .dashboard-container {
            margin-bottom: 20px;
        }
        .dashboard-container h2 {
            margin: 0 0 20px;
            color: #333;
        }
        .content-wrapper {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }
        .pie-chart-container {
            width: 100%;
            max-width: 450px;
        }
        .customer-count {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 250px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
            font-size: 1.2em;
            color: #333;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function toggleUsername() {
            const username = document.getElementById('username');
            username.style.display = username.style.display === 'none' ? 'block' : 'none';
        }

        // Pie Chart Data
        const pieData = {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: 'My First Dataset',
                data: [300, 50, 100, 80, 150, 200],
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(153, 102, 255)',
                    'rgb(255, 159, 64)'
                ],
                hoverOffset: 4
            }]
        };

        // Pie Chart Configuration
        const config = {
            type: 'pie',
            data: pieData,
        };

        // Render Pie Chart
        window.onload = function() {
            const pieChart = new Chart(
                document.getElementById('pieChart'),
                config
            );
        };
    </script>
</head>
<body>
    <div class="header">
        <div class="user-profile" onclick="toggleUsername()">
            <img src="<?php echo htmlspecialchars($profilePic); ?>" alt="Profile Picture">
            <p id="username"><?php echo htmlspecialchars($_SESSION['username']); ?></p>
        </div>
    </div>
    <div class="sidebar">
        <div class="logo">
            <img src="image/mot.pic.jpeg" alt="Logo">
        </div>
        <a href="admin_dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
        <a href="list_of_shops.php"><i class="fas fa-store"></i> List of Shops</a>
        <a href="map.php"><i class="fas fa-map"></i> Map</a>
        <a href="records.php"><i class="fas fa-file-alt"></i> Records</a>
        <a href="account_management.php"><i class="fas fa-users-cog"></i> Account Management</a>
        <a href="logout.php" class="logout-button"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    <div class="main-content">
        <div class="dashboard-container">
            <div class="content-wrapper">
                <!-- Pie Chart Section -->
                <div class="pie-chart-container">
                    <canvas id="pieChart"></canvas>
                </div>
                <!-- Customer Count Section -->
                <div class="customer-count">
                    Number of Customers: <strong>50</strong>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
