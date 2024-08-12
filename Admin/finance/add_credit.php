<?php
require_once('../config/config.php');

session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php"); 
    exit();
}

$username = $_SESSION['admin_username'];

// Fetch users for the dropdown
try {
    $stmt = $pdo->query("SELECT id, username FROM users ");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

// Fetch symbols for the dropdown
try {
    $stmt = $pdo->query("SELECT id, symbol, name FROM cryptocoin WHERE status = 1");
    $cryptocoins = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $currency_id = $_POST['currency_id'];
    $amount = $_POST['amount'];
    $note = $_POST['note'];

    try {
        $sql = "INSERT INTO balance (user_id, currency_id, currency_symbol, balance, note) 
                VALUES (?, ?, (SELECT symbol FROM cryptocoin WHERE id = ?), ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id, $currency_id, $currency_id, $amount, $note]);

        // Redirect to a success page or list page
        header("Location: credit_list.php");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Credit</title>
    <link rel="shortcut icon" href="../assets/images/favicon.ico" />
    <link rel="stylesheet" href="../assets/css/libs.min.css">
    <link rel="stylesheet" href="../assets/css/coinex.css?v=1.0.0">
    <style>
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .form-container h2 {
            margin-bottom: 20px;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
        }

        .form-container label {
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-container input[type="text"],
        .form-container select,
        .form-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .form-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
        }

        .form-container input[type="submit"]:hover {
            background-color: #45a049;
        }

        .form-container .back-link {
            margin-top: 20px;
            display: inline-block;
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }

        .form-container .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body class="sb-nav-fixed">
    <?php include_once '../includes/nav.php'; ?>
    <?php include_once '../includes/sidebar.php'; ?>

    <main class="main-content">
        <div class="form-container">
            <h2>Add Credit</h2>
            <form action="" method="POST">
                <label for="user_id">User:</label>
                <select name="user_id" id="user_id" required>
                    <option value="">Select a User</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo htmlspecialchars($user['id']); ?>">
                            <?php echo htmlspecialchars($user['id']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="currency_id">Currency Symbol:</label>
                <select name="currency_id" id="currency_id" required>
                    <option value="">Select a Currency</option>
                    <?php foreach ($cryptocoins as $coin): ?>
                        <option value="<?php echo htmlspecialchars($coin['id']); ?>">
                            <?php echo htmlspecialchars($coin['name'] . ' (' . $coin['symbol'] . ')'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="amount">Amount:</label>
                <input type="text" id="amount" name="amount" required>

                <label for="note">Note:</label>
                <textarea id="note" name="note"></textarea>

                <input type="submit" value="Add Credit">
            </form>

            <a href="credit_list.php" class="back-link">Back to credit List</a>
        </div>
    </main>

    <!-- Backend Bundle JavaScript -->
    <script src="../assets/js/libs.min.js"></script>
    <!-- widgetchart JavaScript -->
    <script src="../assets/js/charts/widgetcharts.js"></script>
    <!-- fslightbox JavaScript -->
    <script src="../assets/js/fslightbox.js"></script>
    <!-- app JavaScript -->
    <script src="../assets/js/app.js"></script>
    <!-- apexchart JavaScript -->
    <script src="../assets/js/charts/apexcharts.js"></script>
</body>
</html>
