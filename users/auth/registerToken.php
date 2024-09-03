<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../config/config.php'; 

if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];

    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND verification_token = ? and is_active = 0");
    $stmt->execute([$email, $token]);
    $user = $stmt->fetch();

    if ($user) {
        
        $stmt = $pdo->prepare("UPDATE users SET is_active = 1, verification_token = NULL WHERE email = ?");
        $stmt->execute([$email]);

        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];

        
        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Invalid verification link or the account has already been verified.";
        header("Location: login.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "Invalid request.";
    header("Location: login.php");
    exit();
}
