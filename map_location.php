<?php
session_start();
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map Location</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 25px;
            background-color: #7997aa;
            color: #ecf0f1;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .header .user-profile {
            display: flex;
            align-items: center;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 20px;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            margin-left: auto;
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
        }

        .sidebar {
            width: 260px;
            background-color: #7997aa;
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

        .sidebar a {
            color: #ecf0f1;
            text-decoration: none;
            display: block;
            width: 100%;
            padding: 12px;
            margin: 6px 0;
            font-size: 1.1em;
            text-align: center;
            border-radius: 5px;
            transition: background-color 0.3s ease, padding-left 0.3s ease;
        }

        .sidebar a:hover {
            background-color: #34495e;
            padding-left: 15px;
        }

        .sidebar a i {
            margin-right: 12px;
        }

        .main-content {
            margin-left: 270px;
            padding: 20px;
        }

        #map {
            height: 80vh;
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }
    </style>
    <script>
        function initMap() {
            // Create a map centered on Lian Poblacion
            const mapOptions = {
                center: { lat: 13.6667, lng: 122.5833 }, // Coordinates for Lian Poblacion
                zoom: 12,
                mapTypeId: 'roadmap'
            };
            const map = new google.maps.Map(document.getElementById('map'), mapOptions);

            // Add markers for shops (replace with actual data if available)
            const shops = [
                { name: 'Shop 1', position: { lat: 13.665, lng: 122.580 } },
                { name: 'Shop 2', position: { lat: 13.670, lng: 122.590 } },
                { name: 'Shop 3', position: { lat: 13.660, lng: 122.575 } }
                // Add more shops here
            ];

            shops.forEach(shop => {
                new google.maps.Marker({
                    position: shop.position,
                    map: map,
                    title: shop.name
                });
            });
        }
    </script>
</head>
<body onload="initMap()">
    <div class="header">
        <div class="user-profile">
            <img src="image/profile-pic.jpg" alt="Profile Picture">
            <p><?php echo htmlspecialchars($_SESSION['username']); ?></p>
        </div>
    </div>
    <div class="sidebar">
        <div class="logo">
            <img src="image/moto.pic.jpeg" alt="Logo">
        </div>
        <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
        <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
        <a href="map_location.php"><i class="fas fa-map"></i> Map Location</a>
        <a href="logout.php" class="logout-button"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
    <div class="main-content">
        <div id="map"></div>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDlThyDpXWbXHIgy70qPwzNHr0vPe3U27M&callback=initMap" async defer></script>
</body>
</html>
