<?php
require_once('../config/config.php');
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}

$error = '';

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

            // Insert the fee into the database
            $stmt = $pdo->prepare("INSERT INTO fees (currency_id, currency_symbol, level, fees) VALUES (:currency_id, :currency_symbol, :niveau, :fees)");
            $stmt->bindParam(':currency_id', $cryptocurrency_id, PDO::PARAM_INT);
            $stmt->bindParam(':currency_symbol', $cryptocurrency_symbol, PDO::PARAM_STR);
            $stmt->bindParam(':niveau', $niveau, PDO::PARAM_STR);
            $stmt->bindParam(':fees', $fees, PDO::PARAM_STR);
            $stmt->execute();

            header("Location: fees.php?status=success");
            exit();
        } catch (PDOException $e) {
            $error = "Error adding fees: " . $e->getMessage();
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    } else {
        $error = "Please fill in all fields.";
    }
}

// Fetch existing fees
try {
    $stmt = $pdo->query("SELECT * FROM fees");
    $fees_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error fetching fees: " . $e->getMessage();
}

// Fetch cryptocurrency symbols from the cryptocoin table
try {
    $stmt = $pdo->query("SELECT symbol FROM cryptocoin");
    $cryptocoins = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error fetching cryptocurrencies: " . $e->getMessage();
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
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
            <div class="alert alert-success">Fees added successfully!</div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Add Fee</h5>
                    </div>
                    <div class="card-body">
                        <form action="fees.php" method="post">
                            <div class="mb-3">
                                <label for="cryptocurrency_symbol" class="form-label">Cryptocurrency Symbol</label>
                                <select class="form-control" id="cryptocurrency_symbol" name="cryptocurrency_symbol" required>
                                    <?php foreach ($cryptocoins as $coin): ?>
                                        <option value="<?php echo htmlspecialchars($coin['symbol']); ?>"><?php echo htmlspecialchars($coin['symbol']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="niveau" class="form-label">Niveau</label>
                                <select class="form-control" id="niveau" name="niveau" required>
                                    <option value="buy">Buy</option>
                                    <option value="sell">Sell</option>
                                    <option value="depot">Depot</option>
                                    <option value="transfer">Transfer</option>
                                    <option value="retirer">Retirer</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="fees" class="form-label">Fees</label>
                                <input type="number" class="form-control" id="fees" name="fees" step="0.01" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Add Fee</button>
                        </form>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title">Existing Fees</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cryptocurrency Symbol</th>
                                    <th>Niveau</th>
                                    <th>Fees</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($fees_list)): ?>
                                    <?php foreach ($fees_list as $fee): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($fee['id']); ?></td>
                                            <td><?php echo htmlspecialchars($fee['currency_symbol']); ?></td>
                                            <td><?php echo htmlspecialchars($fee['level']); ?></td>
                                            <td><?php echo htmlspecialchars($fee['fees']); ?></td>
                                            <td>
                                                <a href="edit_fee.php?id=<?php echo $fee['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No fees found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
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
