<?php
require_once('../config/config.php');


session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php"); 
    exit();
}

$username = $_SESSION['admin_username'];


if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the market details
    $sql = "SELECT * FROM market WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $market = $stmt->fetch();

    if (!$market) {
        echo "Market not found.";
        exit;
    }

    // Fetch available symbols for the dropdown
    $symbolsSql = "SELECT symbol, name FROM cryptocoin";
    $symbolsStmt = $pdo->query($symbolsSql);
    $cryptocoins = $symbolsStmt->fetchAll();
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $full_name = $_POST['full_name'];
    $symbol = $_POST['symbol'];
    $status = $_POST['status'];

    // Update market details
    $sql = "UPDATE market SET name = ?, full_name = ?, symbol = ?, status = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $full_name, $symbol, $status, $id]);

    header("Location: market_list.php"); 
    exit;
} else {
    echo "Invalid request.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Market</title>
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
        .form-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .form-container input[type="submit"],
        .form-container button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
        }

        .form-container input[type="submit"]:hover,
        .form-container button:hover {
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
            <h2>Edit Market</h2>
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($market['id']); ?>">

                <label for="name">Market Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($market['name']); ?>" required>

                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($market['full_name']); ?>">

                <label for="symbol">Symbol:</label>
                <select name="symbol" id="symbol" required>
                    <option value="">Select a Symbol</option>
                    <?php foreach ($cryptocoins as $coin): ?>
                        <option value="<?php echo htmlspecialchars($coin['symbol']); ?>" <?php echo $market['symbol'] == $coin['symbol'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($coin['name'] . ' (' . $coin['symbol'] . ')'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="status">Status:</label>
                <select name="status" id="status" required>
                    <option value="1" <?php echo $market['status'] == '1' ? 'selected' : ''; ?>>Active</option>
                    <option value="0" <?php echo $market['status'] == '0' ? 'selected' : ''; ?>>Inactive</option>
                </select>

                <input type="submit" value="Update Market">
            </form>

            <a href="market_list.php" class="back-link">Back to Market List</a>
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
