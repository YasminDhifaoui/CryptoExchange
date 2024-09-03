<?php
require_once('../config/config.php');

session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php"); 
    exit();
}

$username = $_SESSION['admin_username'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $name = htmlspecialchars(trim($_POST['name']));
    $symbol = htmlspecialchars(trim($_POST['symbol']));
    $decimal_value = filter_var($_POST['decimal_value'], FILTER_VALIDATE_FLOAT);
    $coin_name = htmlspecialchars(trim($_POST['coin_name']));
    $full_name = htmlspecialchars(trim($_POST['full_name']));
    $proof_type = $_POST['proof_type'];
    $show_home = $_POST['show_home'];
    $rank = filter_var($_POST['rank'], FILTER_VALIDATE_INT);
    $status = $_POST['status'];

    $image = null;
    $target_file = null;

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileNameCmps = explode(".", $image);
        $fileExtension = strtolower(end($fileNameCmps));

        // Sanitize the file name
        $newFileName = $name . '_image.' . $fileExtension;

        // Directory in which to save the file
        $uploadFileDir = '../uploads/cryptocurrencies/';
        $dest_path = $uploadFileDir . $newFileName;

        // Allow certain file formats
        $allowedfileExtensions = array('jpg', 'jpeg', 'png', 'gif','webp');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $target_file = $dest_path; // Set the target file to be stored in the database
            } else {
                echo "There was an error moving the uploaded file.";
            }
        } else {
            echo "Upload failed. Allowed file types: " . implode(',', $allowedfileExtensions);
        }
    }

    $sql = "INSERT INTO cryptocoin (name, symbol, decimal_value, coin_name, full_name, proof_type, show_home, rank, status, image) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([$name, $symbol, $decimal_value, $coin_name, $full_name, $proof_type, $show_home, $rank, $status, $target_file]);
        header("Location: cryptocoin_list.php");
        exit;
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
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
        .form-container select,
        .form-container input[type="file"] {
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
            <h2>Create New Cryptocurrency</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required> <br>

                <label for="symbol">Symbol:</label>
                <input type="text" id="symbol" name="symbol" required> <br>

                <label for="decimal_value">Decimal Value:</label>
                <input type="text" id="decimal_value" name="decimal_value" required> <br>

                <label for="coin_name">Coin Name:</label>
                <input type="text" id="coin_name" name="coin_name" required> <br>

                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name"> <br>

                <label for="proof_type">Proof Type:</label>
                <select id="proof_type" name="proof_type" required>
                    <option value="crypto">Local Coin</option>
                    <option value="fiat">Fiat Currency</option>
                </select> <br>

                <label for="show_home">Show Home:</label>
                <input type="radio" id="showHomeYes" name="show_home" value="1"> Yes
                <input type="radio" id="showHomeNo" name="show_home" value="0"> No
                <br>

                <label for="rank">Rank:</label>
                <input type="text" id="rank" name="rank"> <br>

                <label for="status">Status:</label>
                <select name="status" id="status" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select> <br>

                <label for="image">Coin Image/Icon/Logo:</label>
                <input type="file" id="image" name="image" accept="image/*"> <br>

                <button type="submit">Create Cryptocurrency</button>
            </form>

            <a href="cryptocoin_list.php" class="back-link">Back to Cryptocurrency List</a>
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
