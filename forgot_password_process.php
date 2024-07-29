<?php
session_start();
include 'config.php'; // Ensure this file contains your database connection code

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Validate the email address
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Prepare and execute SQL query
        $query = "SELECT id, username FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch user information
            $user = $result->fetch_assoc();
            $userId = $user['id'];
            $username = $user['username'];

            // Generate a unique token
            $token = bin2hex(random_bytes(50));

            // Store the token and expiry date in the database
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token valid for 1 hour
            $updateQuery = "UPDATE users SET reset_token = ?, token_expiry = ? WHERE id = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param('ssi', $token, $expiry, $userId);
            $updateStmt->execute();

            // Send password reset email
            $resetLink = "http://yourdomain.com/reset_password.php?token=$token";
            $subject = "Password Reset Request";
            $message = "Hello $username,\n\nTo reset your password, please click the following link: $resetLink\n\nIf you did not request this password reset, please ignore this email.\n\nBest regards,\nYour Company";
            $headers = "From: no-reply@yourdomain.com\r\n";
            $headers .= "Reply-To: no-reply@yourdomain.com\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

            if (mail($email, $subject, $message, $headers)) {
                echo "A password reset email has been sent to your email address.";
            } else {
                echo "Failed to send reset email. Please try again later.";
            }
        } else {
            echo "Email address not found.";
        }

        $stmt->close();
    } else {
        echo "Invalid email address.";
    }

    $conn->close();
}
?>
