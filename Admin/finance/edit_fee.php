<?php
require_once('../config/config.php');
session_start();

if (!isset($_SESSION['admin_username']) || !isset($_SESSION['id'])) {
    header("Location: ../auth/sign-in.php");
    exit();
}

$error = $success = '';
$id = $_GET['id'] ?? null;

// Fetch cryptocurrency symbols for the dropdown
try {
    $stmt = $pdo->query("SELECT symbol FROM cryptocoin");
    $cryptocoins = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error fetching cryptocurrencies: " . $e->getMessage();
}

// Fetch existing fee data if editing
if ($id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM fees WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $fee = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$fee) {
            die("Fee not found.");
        }
    } catch (PDOException $e) {
        $error = "Error fetching fee data: " . $e->getMessage();
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cryptocurrency_symbol = $_POST['cryptocurrency_symbol'] ?? '';
    $niveau = $_POST['niveau'] ?? '';
    $fees = $_POST['fees'] ?? '';

    if (!empty($cryptocurrency_symbol) && !empty($niveau) && !empty($fees)) {
        try {
            // Fetch the currency_id based on the selected cryptocurrency_symbol
            $stmt = $pdo->prepare("SELECT id FROM cryptocoin WHERE symbol = :symbol");
            $stmt->bindParam(':symbol', $cryptocurrency_symbol, PDO::PARAM_STR);
            $stmt->execute();
            $cryptocurrency_id = $stmt->fetchColumn();

            if ($cryptocurrency_id === false) {
                throw new Exception("Cryptocurrency symbol not found.");
            }

            // Update the fee in the database
            $stmt = $pdo->prepare("UPDATE fees SET currency_id = :currency_id, currency_symbol = :currency_symbol, level = :niveau, fees = :fees WHERE id = :id");
            $stmt->bindParam(':currency_id', $cryptocurrency_id, PDO::PARAM_INT);
            $stmt->bindParam(':currency_symbol', $cryptocurrency_symbol, PDO::PARAM_STR);
            $stmt->bindParam(':niveau', $niveau, PDO::PARAM_STR);
            $stmt->bindParam(':fees', $fees, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $success = "Fee updated successfully!";
        } catch (PDOException $e) {
            $error = "Error updating fee: " . $e->getMessage();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/libs.min.css">
    <link rel="stylesheet" href="../assets/css/coinex.css?v=1.0.0">  
    <?php include_once '../includes/title.php';?>
</head>
<body class="sb-nav-fixed">
<?php include_once '../includes/nav.php'; ?>
<?php include_once '../includes/sidebar.php'; ?>

<main class="main-content">
    <div class="container-fluid content-inner pb-0">
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php elseif ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Edit Fee</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="cryptocurrency_symbol" class="form-label">Cryptocurrency Symbol</label>
                                <select class="form-control" id="cryptocurrency_symbol" name="cryptocurrency_symbol" required>
                                    <?php foreach ($cryptocoins as $coin): ?>
                                        <option value="<?php echo htmlspecialchars($coin['symbol']); ?>" <?php echo ($coin['symbol'] === $fee['currency_symbol']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($coin['symbol']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="niveau" class="form-label">Niveau</label>
                                <select class="form-control" id="niveau" name="niveau" required>
                                    <option value="buy" <?php echo ($fee['level'] === 'buy') ? 'selected' : ''; ?>>Buy</option>
                                    <option value="sell" <?php echo ($fee['level'] === 'sell') ? 'selected' : ''; ?>>Sell</option>
                                    <option value="depot" <?php echo ($fee['level'] === 'depot') ? 'selected' : ''; ?>>Depot</option>
                                    <option value="transfer" <?php echo ($fee['level'] === 'transfer') ? 'selected' : ''; ?>>Transfer</option>
                                    <option value="retirer" <?php echo ($fee['level'] === 'retirer') ? 'selected' : ''; ?>>Retirer</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="fees" class="form-label">Fees</label>
                                <input type="number" class="form-control" id="fees" name="fees" step="0.01" value="<?php echo htmlspecialchars($fee['fees']); ?>" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include_once '../includes/footer.php'; ?>

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
