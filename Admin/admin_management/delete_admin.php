<?php
require_once('../config/config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM admin WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    header("Location: admin_list.php");
    exit;
} else {
    echo "Invalid request.";
    exit;
}
?>
