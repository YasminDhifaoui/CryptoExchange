<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    // Include your database connection file (config.php)
    require_once('../../config/config.php');

    // Get the username from the session
    $username = $_SESSION['username'];

    // Update user status in the database
    $updateSql = "UPDATE users SET is_active = 0  WHERE username = :username";
    $stmt = $pdo->prepare($updateSql);
    $stmt->execute(['username' => $username]);

    // Clear all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect to the login page with a logout message
    header('Location: login.php?logout=success');
    exit();
} else {
    // Redirect to the login page if no user is logged in
    header('Location: login.php');
    exit();
}
?>
