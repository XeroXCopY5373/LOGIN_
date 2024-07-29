<?php
session_start();
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Fetch the user's role from the database
$username = $_SESSION['username'];
$query = "SELECT role FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Check if the user has a valid role
if (!$row || $row['role'] !== 'userclient') {
    // Redirect to admin dashboard if the role is not 'userclient'
    header("Location: admin_dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
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
    background-color: #bacdd5
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: relative;
    padding: 15px 25px;
    background-color: #c3d4e4;
    color: #ecf0f1;
    box-shadow: 0 3px 4px rgba(0, 0, 0, 0.1);
    position: center;
}

.header .user-profile {
    display: flex;
    align-items: center;
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-radius: 20px;
    padding: 3px 3px;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
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
    font-size: 0.1em;
    color: #333;
    font-weight: bold;
}

.sidebar {
    width: 250px;
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

.sidebar .logout-button {
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

.sidebar .logout-button:hover {
    background-color: #c0392b;
}


.main-content {
    flex: 1;
    padding: 20px;
    margin-left: 270px;
    margin-top: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    height: calc(100vh - 60px);
}

#chatbot {
    display: flex;
    flex-direction: column;
    flex: 1;
    background-color: #ffffff;
    border-radius: 5px;
    box-shadow: 0 0 5px rgba(0,0,0,0.1);
    overflow: hidden;
    height: 100%;
}

#messages {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    background-color: #f9f9f9;
}

#chatbot .message {
    margin: 10px 0;
    padding: 10px 15px;
    border-radius: 15px;
    max-width: 75%;
    word-wrap: break-word;
    line-height: 1.5;
    font-size: 1em;
}

#chatbot .message.user {
    background-color: #007bff;
    color: #ffffff;
    margin-left: auto;
    text-align: right;
}

#chatbot .message.bot {
    background-color: #e1e1e1;
    margin-right: auto;
}

#chatbot input {
    width: calc(100% - 22px);
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin: 0 10px 10px;
    box-sizing: border-box;
}

#chatbot button {
    width: calc(100% - 22px);
    padding: 10px;
    border: none;
    background-color: #007bff;
    color: #ffffff;
    border-radius: 4px;
    cursor: pointer;
    margin: 0 10px 10px;
}

    </style>
    <script>
        function toggleUsername() {
            const username = document.getElementById('username');
            username.style.display = username.style.display === 'none' ? 'block' : 'none';
        }

        // Simulate chatbot response
        function getBotResponse(userInput) {
            const responses = {
                "hi": "Hello! How can I assist you today?",
                "help": "Sure, I can help you. What do you need assistance with?",
                "shop": "I can provide information on motorcycle shops. What area are you looking in?",
                "location": "I can help you find locations. Please provide more details."
            };
            return responses[userInput.toLowerCase()] || "I'm not sure how to respond to that. Can you please clarify?";
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('send-button').addEventListener('click', function() {
                const userInput = document.getElementById('user-input').value.trim();
                if (userInput === '') return;

                const messages = document.getElementById('messages');
                const userMessage = document.createElement('div');
                userMessage.classList.add('message', 'user');
                userMessage.textContent = userInput;
                messages.appendChild(userMessage);

                document.getElementById('user-input').value = '';

                const botResponse = document.createElement('div');
                botResponse.classList.add('message', 'bot');
                botResponse.textContent = getBotResponse(userInput);
                messages.appendChild(botResponse);

                messages.scrollTop = messages.scrollHeight;
            });

            // Optional: Allow pressing Enter to send the message
            document.getElementById('user-input').addEventListener('keypress', function(event) {
                if (event.key === 'Enter') {
                    document.getElementById('send-button').click();
                }
            });
        });
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
    <a href="profile.php"><i class="fas fa-user"></i> Profile</a>
    <a href="settings.php"><i class="fas fa-cog"></i> Settings</a>
    <a href="map_location.php"><i class="fas fa-map"></i> Map Location</a>
    <a href="logout.php" class="logout-button"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="main-content">
    <div id="chatbot">
        <div id="messages"></div>
        <input type="text" id="user-input" placeholder="Type your message...">
        <button id="send-button">Send</button>
    </div>
</div>
</body>
</html>
