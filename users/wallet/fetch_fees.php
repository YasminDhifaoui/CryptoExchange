<?php
require_once('../../config/config.php');

$currency_symbol = $_GET['currency_symbol'] ?? '';

if ($currency_symbol) {
    $stmt = $pdo->prepare("SELECT fees FROM fees WHERE currency_symbol = :currency_symbol AND level = 'transfer'");
    $stmt->execute(['currency_symbol' => $currency_symbol]);
    $fees = $stmt->fetchColumn();

    echo json_encode(['fees' => $fees !== false ? $fees : null]);
} else {
    echo json_encode(['fees' => null]);
}
?>
