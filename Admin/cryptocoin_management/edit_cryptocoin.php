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

    $sql = "SELECT * FROM cryptocoin WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $crypto = $stmt->fetch();

    if (!$crypto) {
        echo "Cryptocurrency not found.";
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = htmlspecialchars(trim($_POST['name']));
    $symbol = htmlspecialchars(trim($_POST['symbol']));
    $decimal_value = filter_var($_POST['decimal_value'], FILTER_VALIDATE_FLOAT);
    $coin_name = htmlspecialchars(trim($_POST['coin_name']));
    $full_name = htmlspecialchars(trim($_POST['full_name']));
    $proof_type = $_POST['proof_type'];
    $show_home = $_POST['show_home'];
    $rank = filter_var($_POST['rank'], FILTER_VALIDATE_INT);
    $status = $_POST['status'];

    // Update main fields
    $sql = "UPDATE cryptocoin SET name = ?, symbol = ?, decimal_value = ?, coin_name = ?, full_name = ?, proof_type = ?, show_home = ?, rank = ?, status = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $symbol, $decimal_value, $coin_name, $full_name, $proof_type, $show_home, $rank, $status, $id]);

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileNameCmps = explode(".", $image);
        $fileExtension = strtolower(end($fileNameCmps));

        // Sanitize and create the new file name
        $newFileName = $name . '_image.' . $fileExtension;

        // Directory to save the uploaded file
        $uploadFileDir = '../uploads/cryptocurrencies/';
        $dest_path = $uploadFileDir . $newFileName;

        // Allowed file extensions
        $allowedfileExtensions = array('jpg', 'jpeg', 'png', 'gif','webp');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // Update the image path in the database
                $sql = "UPDATE cryptocoin SET image = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$dest_path, $id]);
            } else {
                echo "Error uploading the file.";
            }
        } else {
            echo "Upload failed. Allowed file types: " . implode(',', $allowedfileExtensions);
        }
    }

    header("Location: cryptocoin_list.php"); 
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
    <title>Edit Cryptocurrency</title>
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

        .form-container img {
            margin-top: 10px;
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body class="sb-nav-fixed">
    <?php include_once '../includes/nav.php'; ?>
    <?php include_once '../includes/sidebar.php'; ?>

    <main class="main-content">
        <div class="form-container">
            <h2>Edit Cryptocurrency</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($crypto['id']); ?>">

                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($crypto['name']); ?>" required> <br>

                <label for="symbol">Symbol:</label>
                <input type="text" id="symbol" name="symbol" value="<?php echo htmlspecialchars($crypto['symbol']); ?>" required> <br>

                <label for="decimal_value">Decimal Value:</label>
                <input type="text" id="decimal_value" name="decimal_value" value="<?php echo htmlspecialchars($crypto['decimal_value']); ?>" required> <br>

                <label for="coin_name">Coin Name:</label>
                <input type="text" id="coin_name" name="coin_name" value="<?php echo htmlspecialchars($crypto['coin_name']); ?>" required> <br>

                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($crypto['full_name']); ?>"> <br>

                <label for="proof_type">Proof Type:</label>
                <select id="proof_type" name="proof_type" required>
                    <option value="local_coin" <?php echo $crypto['proof_type'] == 'local_coin' ? 'selected' : ''; ?>>Local Coin</option>
                    <option value="fiat_currency" <?php echo $crypto['proof_type'] == 'fiat_currency' ? 'selected' : ''; ?>>Fiat Currency</option>
                </select> <br>

                <label for="show_home">Show Home:</label>
                <input type="radio" id="showHomeYes" name="show_home" value="1" <?php echo $crypto['show_home'] == '1' ? 'checked' : ''; ?>> Yes
                <input type="radio" id="showHomeNo" name="show_home" value="0" <?php echo $crypto['show_home'] == '0' ? 'checked' : ''; ?>> No
                <br>

                <label for="rank">Rank:</label>
                <input type="text" id="rank" name="rank" value="<?php echo htmlspecialchars($crypto['rank']); ?>"> <br>

                <label for="status">Status:</label>
                <select name="status" id="status" required>
                    <option value="1" <?php echo $crypto['status'] == '1' ? 'selected' : ''; ?>>Active</option>
                    <option value="0" <?php echo $crypto['status'] == '0' ? 'selected' : ''; ?>>Inactive</option>
                </select>
                <br>

                <label for="image">Coin Image/Icon/Logo:</label>
                <input type="file" id="image" name="image" accept="image/*"> <br>

                <?php if (!empty($crypto['image'])): ?>
                    <img src="<?php echo htmlspecialchars($crypto['image']); ?>" alt="Cryptocurrency Image">
                <?php endif; ?>
                
                <br>

                <button type="submit">Update Cryptocurrency</button>
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
