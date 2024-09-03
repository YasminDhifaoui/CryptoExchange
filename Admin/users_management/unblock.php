<?php
require_once('../../config/config.php');

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM blocklist WHERE id = :id");
        $stmt->execute(['id' => $id]);

        header("Location: blocklist.php?message=User successfully unblocked.");
        exit();
    } catch (PDOException $e) {
        header("Location: blocklist.php?message=Failed to unblock user: " . $e->getMessage());
        exit();
    }
} else {
    header("Location: blocklist.php?message=Invalid request.");
    exit();
}
?>
