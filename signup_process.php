<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="login_process.php" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            <button type="submit">Login</button>
        </form>
        <p><a href="signup.php">Don't have an account? Sign up here.</a></p>
        <p><a href="forgot_password.php">Forgot Password?</a></p>
        <p><a href="google_login.php">Login with Google</a></p>
    </div>
</body>
</html>
login.php
<?php
session_start();
session_unset();
session_destroy();
header("Location: index.php");
exit();
?>
logout.php
<?php
session_start();
include 'config.php'; // Ensure this file contains your database connection code

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize form data
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
    $role = 'userclient'; // Default role; adjust as needed

    // Validate username
    if (empty($username) || strlen($username) > 50) {
        echo "Invalid username.";
        exit();
    }

    // Validate password
    if (strlen($password) < 8) {
        echo "Password must be at least 8 characters long.";
        exit();
    }

    // Check if the username already exists
    $checkUsernameQuery = "SELECT id FROM users WHERE username = ?";
    if ($checkUsernameStmt = $conn->prepare($checkUsernameQuery)) {
        $checkUsernameStmt->bind_param('s', $username);
        $checkUsernameStmt->execute();
        $checkUsernameStmt->store_result();

        if ($checkUsernameStmt->num_rows > 0) {
            echo "Username is already registered.";
            $checkUsernameStmt->close();
            exit();
        }

        $checkUsernameStmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and execute the SQL query to insert user data
    $query = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('sss', $username, $hashedPassword, $role);

        if ($stmt->execute()) {
            // Redirect to login page after successful registration
            header('Location: login.php'); // Adjust 'login.php' to your actual login page path
            exit(); // Ensure no further code is executed
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    $conn->close();
}
?>