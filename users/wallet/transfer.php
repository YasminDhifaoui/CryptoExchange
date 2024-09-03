<?php
session_start();
require_once('../../config/config.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
$receivers = $pdo->query("SELECT id, username FROM users")->fetchAll(PDO::FETCH_ASSOC);

$currencies = $pdo->query("SELECT symbol FROM cryptocoin")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sender_user_id = $_SESSION['user_id'];
    $receiver_user_id = $_POST['receiver_user_id'];
    $amount = $_POST['amount'];
    $currency_symbol = $_POST['currency_symbol'];
    $request_ip = $_SERVER['REMOTE_ADDR'];
    $date = date('Y-m-d');
    $comments = $_POST['comments'];

    $stmt = $pdo->prepare("SELECT fees FROM fees WHERE currency_symbol = :currency_symbol AND level = 'transfer'");
    $stmt->execute(['currency_symbol' => $currency_symbol]);
    $fees = $stmt->fetchColumn();

    if ($fees === false) {
        echo "Error: No fees found for the selected currency.";
        exit();
    }

    $stmt = $pdo->prepare("INSERT INTO transfer (sender_user_id, receiver_user_id, amount, currency_symbol, fees, request_ip, date, comments)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$sender_user_id, $receiver_user_id, $amount, $currency_symbol, $fees, $request_ip, $date, $comments]);

    echo "Transfer successfully done.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../includes/title.php'?>
    <link rel="stylesheet" href="../app/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../app/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="../assets/font/risebot.css">
    <link rel="stylesheet" href="../assets/font/font-awesome.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="../app/dist/app.css">
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
    <h4>Transfer</h4>
    <form method="POST" action="transfer.php">
        <div class="form-group">
            <label for="currency_symbol">Currency Symbol:</label>
            <select name="currency_symbol" id="currency_symbol" class="form-control" required>
                <option value="">Select Currency</option>
                <?php foreach ($currencies as $currency): ?>
                    <option value="<?= htmlspecialchars($currency['symbol']); ?>">
                        <?= htmlspecialchars($currency['symbol']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="receiver_user_id">Receiver:</label>
            <select name="receiver_user_id" class="form-control" required>
                <option value="">Select Receiver</option>
                <?php foreach ($receivers as $receiver): ?>
                    <option value="<?= htmlspecialchars($receiver['id']); ?>">
                        <?= htmlspecialchars($receiver['id']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="amount">Amount:</label>
            <input type="number" name="amount" step="0.01" class="form-control" required>
        </div>

        

        <div class="form-group">
            <label for="fees">Fees:</label>
            <input type="text" id="fees" name="fees" class="form-control" readonly>
        </div>

        <div class="form-group">
            <label for="comments">Comments:</label>
            <textarea name="comments" class="form-control"></textarea>
        </div>

       

        <button type="submit" class="btn btn-primary">Submit Transfer</button>
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
        document.getElementById('currency_symbol').addEventListener('change', function() {
            var currencySymbol = this.value;
            if (currencySymbol) {
                fetch('fetch_fees.php?currency_symbol=' + currencySymbol)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('fees').value = data.fees || 'No fees found';
                    })
                    .catch(error => {
                        console.error('Error fetching fees:', error);
                    });
            } else {
                document.getElementById('fees').value = '';
            }
        });
    </script>
</body>
</html>
