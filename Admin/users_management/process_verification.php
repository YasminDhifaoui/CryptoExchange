<?php
require '../config/config.php';
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && isset($_POST['user_id'])) {
        $user_id = htmlspecialchars($_POST['user_id']);
        $action = htmlspecialchars($_POST['action']);
        $status = ($action == 'accept') ? 'Accepted' : 'Refused';
        
        // Set the message based on the action
        $message = ($action == 'accept') 
            ? 'Your verification request has been accepted.' 
            : 'Your verification request has been refused.';

        // Update the verification status
        $stmt = $pdo->prepare("UPDATE verifications SET verif_status = :status WHERE user_id = :user_id");
        $stmt->execute([':status' => $status, ':user_id' => $user_id]);

        // Insert a notification for the user
        $stmt = $pdo->prepare("INSERT INTO notifications (user_id, message) VALUES (:user_id, :message)");
        $stmt->execute([':user_id' => $user_id, ':message' => $message]);

        // Redirect to avoid form resubmission
        header("Location: verification_requests.php");
        exit();
    }
}
