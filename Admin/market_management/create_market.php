<?php
require_once('../config/config.php');

session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php"); 
    exit();
}

$username = $_SESSION['admin_username'];

// Fetch symbols for the dropdown
try {
    $stmt = $pdo->query("SELECT symbol, name FROM cryptocoin WHERE status = 1");
    $cryptocoins = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $full_name = $_POST['full_name'];
    $symbol = $_POST['symbol'];
    $status = $_POST['status'];

    try {
        $sql = "INSERT INTO market (name, full_name, symbol, status) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $full_name, $symbol, $status]);

        // Redirect to a success page or list page
        header("Location: market_list.php");
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
    
    <?php include_once'../includes/title.php';?>
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
            <h2>Add New Market</h2>
            <form action="" method="POST">
                <label for="name">Market Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name">

                <label for="symbol">Symbol:</label>
                <select name="symbol" id="symbol" required>
                    <option value="">Select a Symbol</option>
                    <?php foreach ($cryptocoins as $coin): ?>
                        <option value="<?php echo htmlspecialchars($coin['symbol']); ?>">
                            <?php echo htmlspecialchars($coin['name'] . ' (' . $coin['symbol'] . ')'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="status">Status:</label>
                <select name="status" id="status" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>

                <input type="submit" value="Add Market">
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
