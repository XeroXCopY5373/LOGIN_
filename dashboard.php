<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];
$query = "SELECT role FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$role = isset($row['role']) ? $row['role'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="user-profile">
                <h2>Welcome, <?php echo htmlspecialchars($username); ?></h2>
                <p>Role: <?php echo htmlspecialchars(ucfirst($role)); ?></p>
            </div>
        </header>
        <main class="main-content">
            <?php if ($role === 'admin'): ?>
                <h1>Admin Dashboard</h1>
                <p>Here you can manage users and other administrative tasks.</p>
            <?php else: ?>
                <h1>User Client Dashboard</h1>
                <p>Here you can view your account details and interact with services.</p>
            <?php endif; ?>
            <!-- Chatbot Section -->
            <div class="chatbot-container">
                <div id="chatbot">
                    <div id="chatbot-messages"></div>
                    <input type="text" id="chatbot-input" placeholder="Type a message...">
                    <button>Send</button>
                </div>
            </div>
        </main>
    </div>
    <script src="js/chatbot.js"></script>
</body>
</html>
