<?php
require_once('../config/config.php');

session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php"); 
    exit();
}

$username = $_SESSION['admin_username'];


try {
    $marketQuery = "SELECT name FROM market WHERE status = 1";
    $marketStmt = $pdo->query($marketQuery);
    $markets = $marketStmt->fetchAll(PDO::FETCH_ASSOC);

    $cryptocoinQuery = "SELECT name FROM cryptocoin WHERE status = 1";
    $cryptocoinStmt = $pdo->query($cryptocoinQuery);
    $cryptocoins = $cryptocoinStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching data: " . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = "SELECT * FROM pair_coin WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $pairCoin = $stmt->fetch();

        if (!$pairCoin) {
            echo "Pair coin not found.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error fetching pair coin data: " . $e->getMessage();
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $fullname = trim($_POST['fullname']);
    $market_name = trim($_POST['market_name']);
    $cryptocoin_name = trim($_POST['cryptocoin_name']);
    $initial_price = trim($_POST['initial_price']);
    $status = (isset($_POST['status']) && $_POST['status'] == '1') ? 1 : 0; 

    $errors = [];

    if (empty($name)) {
        $errors[] = "Pair name is required.";
    }
    if (empty($fullname)) {
        $errors[] = "Full name is required.";
    }
    if (empty($market_name)) {
        $errors[] = "Market selection is required.";
    }
    if (empty($cryptocoin_name)) {
        $errors[] = "Cryptocurrency selection is required.";
    }
    if (!is_numeric($initial_price) || $initial_price <= 0) {
        $errors[] = "Initial price must be a positive number.";
    }

    if (empty($errors)) {
        try {
            $updateQuery = "UPDATE pair_coin SET name = ?, fullname = ?, market_name = ?, cryptocoin_name = ?, initial_price = ?, status = ? WHERE id = ?";
            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->execute([$name, $fullname, $market_name, $cryptocoin_name, $initial_price, $status, $id]);

            header("Location: pairCoin_list.php");
            exit;
        } catch (PDOException $e) {
            $errors[] = "Error updating data: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pair Coin</title>
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
        .form-container input[type="number"],
        .form-container select {
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

        .error-message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body class="sb-nav-fixed">
    <?php include_once '../includes/nav.php'; ?>
    <?php include_once '../includes/sidebar.php'; ?>

    <main class="main-content">
        <div class="form-container">
            <h2>Edit Pair Coin</h2>

            <?php if (!empty($errors)): ?>
                <div class="error-message">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($pairCoin['id']); ?>">

                <label for="name">Pair Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($pairCoin['name']); ?>" required>

                <label for="fullname">Full Name:</label>
                <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($pairCoin['fullname']); ?>" required>

                <label for="market_name">Market:</label>
                <select name="market_name" id="market_name" required>
                    <option value="">Select a Market</option>
                    <?php foreach ($markets as $market): ?>
                        <option value="<?php echo htmlspecialchars($market['name']); ?>" <?php echo ($pairCoin['market_name'] == $market['name']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($market['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="cryptocoin_name">Cryptocurrency:</label>
                <select name="cryptocoin_name" id="cryptocoin_name" required>
                    <option value="">Select a Cryptocurrency</option>
                    <?php foreach ($cryptocoins as $coin): ?>
                        <option value="<?php echo htmlspecialchars($coin['name']); ?>" <?php echo ($pairCoin['cryptocoin_name'] == $coin['name']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($coin['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="initial_price">Initial Price:</label>
                <input type="number" id="initial_price" name="initial_price" step="0.001" min="0" value="<?php echo htmlspecialchars($pairCoin['initial_price']); ?>" required>

                <label for="status">Status:</label>
                <select name="status" id="status" required>
                    <option value="1" <?php echo ($pairCoin['status'] == 1) ? 'selected' : ''; ?>>Active</option>
                    <option value="0" <?php echo ($pairCoin['status'] == 0) ? 'selected' : ''; ?>>Inactive</option>
                </select>

                <input type="submit" value="Update Pair Coin">
            </form>

            <a href="pair_coin_list.php" class="back-link">Back to Pair Coin List</a>
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
