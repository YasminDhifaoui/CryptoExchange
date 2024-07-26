<?php
require_once('../../config/config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM cryptocoin WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    header("Location: cryptocoin_list.php");
    exit;
} else {
    echo "Invalid request.";
    exit;
}
?>
