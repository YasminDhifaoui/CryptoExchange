<?php
session_start();
require_once('../../config/config.php');

if (isset($_GET['deposit_type'])) {
    $depositType = htmlspecialchars($_GET['deposit_type']);

    if ($depositType === 'crypto') {
        $cryptoCoinsSql = 'SELECT * FROM cryptocoin WHERE proof_type = :deposit_type';
        $cryptoCoinsStmt = $pdo->prepare($cryptoCoinsSql);
        $cryptoCoinsStmt->execute(['deposit_type' => 'crypto']);
        $cryptoCoins = $cryptoCoinsStmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($cryptoCoins);
        exit();
    } else if ($depositType === 'fiat') {
        $fiatCurrenciesSql = 'SELECT * FROM cryptocoin WHERE proof_type = :deposit_type';
        $fiatCurrenciesStmt = $pdo->prepare($fiatCurrenciesSql);
        $fiatCurrenciesStmt->execute(['deposit_type' => 'fiat']);
        $fiatCurrencies = $fiatCurrenciesStmt->fetchAll(PDO::FETCH_ASSOC);

        header('Content-Type: application/json');
        echo json_encode($fiatCurrencies);
        exit();
    } else {
        // Handle other types if needed
        header('Content-Type: application/json');
        echo json_encode([]);
        exit();
    }
}
?>
