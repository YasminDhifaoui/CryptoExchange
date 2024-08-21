<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
$username = htmlspecialchars($_SESSION['username']);
$id = isset($_SESSION['id']) ? htmlspecialchars($_SESSION['id']) : 'ID not set';
$email = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'Email not set';

require_once('../../config/config.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $depositType = htmlspecialchars($_POST['deposit_type']);
    $cryptoCoin = isset($_POST['crypto_coin']) ? htmlspecialchars($_POST['crypto_coin']) : null;
    $depositMethod = htmlspecialchars($_POST['deposit_method']);

    $paymentGateway = htmlspecialchars($_POST['payment_gateway']); 
    $amount = htmlspecialchars($_POST['amount']);
    $currencySymbol = null;

    // Handle crypto deposits
    if ($depositType === 'crypto' && $cryptoCoin !== null) {
        // Fetch the symbol for the selected cryptocurrency from the database

        $sql = 'SELECT symbol FROM cryptocoin WHERE LOWER(name) = LOWER(:cryptoCoin)';

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['cryptoCoin' => $cryptoCoin]);
        $currencySymbol = $stmt->fetchColumn();

        
        // Ensure that a symbol was fetched
        if ($currencySymbol === false) {
            echo "Error: Cryptocurrency symbol not found for coin: " . $cryptoCoin;
            exit();
        }
    } elseif ($depositType === 'fiat') {
        // For fiat deposits, you can use a fixed symbol, e.g., 'FIAT'
        $currencySymbol = 'USD';
    }

    if ($currencySymbol !== null) {
        // Insert deposit into the database
        $sql = 'INSERT INTO deposit (user_id, currency_symbol, amount, method_id, payment_gateway, status, deposit_date) 
        VALUES (:user_id, :currency_symbol, :amount, :method_id, :payment_gateway, 0, NOW())';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'user_id' => $id,
            'currency_symbol' => $currencySymbol,
            'amount' => $amount,
            'method_id' => $depositMethod,
            'payment_gateway' => $paymentGateway
        ]);

        // Refresh the page to show the updated list of deposits
        header('Location: deposit.php');
        exit();
    } else {
        // Handle case where $currencySymbol is null (optional)
        echo "Error: Currency symbol cannot be null.";
    }
}



// Retrieve deposit type from POST or default to null
$depositType = isset($_POST['deposit_type']) ? htmlspecialchars($_POST['deposit_type']) : null;

// Fetch deposits for the user
$sql = 'SELECT * FROM deposit WHERE user_id = :user_id';
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $id]);
$deposits = $stmt->fetchAll();

// Fetch deposit methods without filtering
$depositMethodsSql = 'SELECT * FROM deposit_methods'; // Adjust table name if necessary
$depositMethodsStmt = $pdo->prepare($depositMethodsSql);
$depositMethodsStmt->execute();
$depositMethods = $depositMethodsStmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit</title>
    <link rel="stylesheet" href="../app/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../app/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="../assets/font/risebot.css">
    <link rel="stylesheet" href="../assets/font/font-awesome.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="../app/dist/app.css">
    <link rel="shortcut icon" href="../assets/images/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/images/favicon.png">
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <style>
        table.table {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <?php include_once '../includes/nav.php'; ?>

    <section class="page-title"> 
        <div class="container">
            <h4>Deposits</h4>
            
            <!-- Deposit Form -->
            <form action="" method="POST">
                <div class="form-group">
                    <label for="deposit_type">Deposit Type</label>
                    <select id="deposit_type" name="deposit_type" class="form-control" required>
                        <option value="fiat">fiat</option>
                        <option value="crypto">crypto</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="crypto_coin">Crypto Coin</label>
                    <select id="crypto_coin" name="crypto_coin" class="form-control">
                        <!-- Options will be populated dynamically -->
                    </select>
                </div>

                <div class="form-group">
                    <label for="payment_gateway">Payment Gateway</label>
                    <select id="payment_gateway" name="payment_gateway" class="form-control" required>
                        <option value="paypal">PayPal</option>
                        <option value="stripe">Stripe</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="crypto_wallet">Crypto Wallet</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="deposit_method">Deposit Method</label>
                    <select id="deposit_method" name="deposit_method" class="form-control" required>
                        <?php foreach ($depositMethods as $method): ?>
                            <option value="<?php echo htmlspecialchars($method['id']); ?>">
                                <?php echo htmlspecialchars($method['id']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" id="amount" name="amount" class="form-control" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Submit Deposit</button>
            </form>

            
        </div>
    </section>
    
    <?php include_once '../includes/footer.php'; ?>

    <script src="../app/js/jquery.min.js"></script>
    <script src="../app/js/bootstrap.min.js"></script>
    <script src="../app/js/swiper-bundle.min.js"></script>
    <script src="../app/js/swiper.js"></script>
    <script src="../app/js/jquery.easing.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="../app/js/parallax.js"></script>
    <script src="../app/js/jquery.magnific-popup.min.js"></script>
    <script src="../app/js/app.js"></script>
    <script src="../app/js/count-down.js"></script>
    <script src="../app/js/plugin.js"></script>
    <script src="../app/js/donatProgress.js"></script> 

    <script>
    document.getElementById('deposit_type').addEventListener('change', function() {
        var depositType = this.value;
        fetchCryptoCoins(depositType);
    });

    function fetchCryptoCoins(depositType) {
        fetch('fetch_crypto_coins.php?deposit_type=' + encodeURIComponent(depositType))
            .then(response => response.json())
            .then(data => {
                var cryptoCoinSelect = document.getElementById('crypto_coin');
                cryptoCoinSelect.innerHTML = ''; // Clear existing options

                if (depositType === 'crypto') {
                    // Populate crypto coins
                    data.forEach(coin => {
                        var option = document.createElement('option');
                        option.value = coin.name;
                        option.textContent = coin.name;
                        cryptoCoinSelect.appendChild(option);
                    });
                } else if (depositType === 'fiat') {
                    data.forEach(fiat => {
                        var option = document.createElement('option');
                        option.value = fiat.name;
                        option.textContent = fiat.name;
                        cryptoCoinSelect.appendChild(option);
                    });
                }
            })
            .catch(error => console.error('Error fetching crypto coins:', error));
    }

    // Initialize with the default deposit type
    document.addEventListener('DOMContentLoaded', function() {
        fetchCryptoCoins(document.getElementById('deposit_type').value);
    });
</script>

</body>
</html>
