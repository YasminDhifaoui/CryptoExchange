<?php
require_once('../config/config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    header("Location: users_list.php");
    exit;
} else {
    echo "Invalid request.";
    exit;
}
?>
