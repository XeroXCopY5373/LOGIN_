<?php
session_start();
require_once 'vendor/autoload.php';

$client = new Google_Client();
$client->setClientId('YOUR_GOOGLE_CLIENT_ID');
$client->setClientSecret('YOUR_GOOGLE_CLIENT_SECRET');
$client->setRedirectUri('YOUR_REDIRECT_URI');
$client->addScope("email");
$client->addScope("profile");

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    $oauth2 = new Google_Service_Oauth2($client);
    $google_account_info = $oauth2->userinfo->get();
    $email =  $google_account_info->email;
    $name =  $google_account_info->name;

    include 'config.php';

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $query = "INSERT INTO users (username, email, role) VALUES (?, ?, 'userclient')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $name, $email);
        $stmt->execute();
    }

    $_SESSION['username'] = $name;
    $_SESSION['email'] = $email;
    header('Location: user_dashboard.php');
    exit();
} else {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
    exit();
}
?>
