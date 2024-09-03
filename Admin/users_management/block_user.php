<?php
require '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userEmail = $_POST['email'] ?? '';
    $isBlocked = $_POST['is_blocked'] ?? 0;

    if ($isBlocked) {
        // Block user: Insert into dbt_blocklist
        $stmt = $pdo->prepare('INSERT INTO blocklist (ip_mail) VALUES (:email)');
        $stmt->execute(['email' => $userEmail]);
    } else {
        // Unblock user: Delete from dbt_blocklist
        $stmt = $pdo->prepare('DELETE FROM blocklist WHERE ip_mail = :email');
        $stmt->execute(['email' => $userEmail]);
    }
}
