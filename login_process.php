<?php
session_start();
include 'config.php'; // Ensure this file contains your database connection code

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    // Check if username and password are not empty
    if (!empty($username) && !empty($password)) {
        // Prepare the SQL statement
        $query = "SELECT * FROM users WHERE username = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            // Verify user and password
            if ($user && password_verify($password, $user['password'])) {
                // Regenerate session ID to prevent session fixation attacks
                session_regenerate_id(true);

                // Set session variables
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $user['role'];

                // Redirect based on user role
                if ($user['role'] === 'admin') {
                    header('Location: admin_dashboard.php');
                } else {
                    header('Location: user_dashboard.php');
                }
                exit();
            } else {
                echo "<p style='color: red;'>Invalid username or password.</p>";
            }
            $stmt->close();
        } else {
            echo "<p style='color: red;'>Error preparing the statement: " . htmlspecialchars($conn->error) . "</p>";
        }
    } else {
        echo "<p style='color: red;'>Please enter both username and password.</p>";
    }
    $conn->close();
}
?>
