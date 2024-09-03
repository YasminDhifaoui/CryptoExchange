<?php
require '../config/config.php';

session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php"); 
    exit();
}

$username = $_SESSION['admin_username'];

$id = $_SESSION['admin_id'];

try {
    // Fetch admin data from the database
    $stmt = $pdo->prepare("SELECT * FROM admin WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if data was fetched correctly
    if (!$admin) {
        $error = "Admin data not found for ID: $id";
    }
} catch (PDOException $e) {
    $error = "Error fetching settings: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    try {
        // Prepare update query
        $sql = "UPDATE admin SET username = :username, email = :email";

        // If password is provided, hash it
        if (!empty($password)) {
            $sql .= ", password = :password";
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        }

        $sql .= " WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        if (!empty($password)) {
            $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
        }

        // Execute update
        $stmt->execute();

        // Redirect on success
        header("Location: adminProfile.php?status=success");
        exit;
    } catch (PDOException $e) {
        $error = "Error updating profile: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once '../includes/title.php';?>
    <link rel="stylesheet" href="../assets/css/libs.min.css">
    <link rel="stylesheet" href="../assets/css/coinex.css?v=1.0.0">  
</head>
<body class="sb-nav-fixed">

<?php include_once '../includes/nav.php'; ?>
<?php include_once '../includes/sidebar.php';?>

<main class="main-content">
    <div class="container-fluid content-inner pb-0">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
            <div class="alert alert-success">
                Profile updated successfully!
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Profile Settings</h5>
                    </div>
                    <div class="card-body">
                        <form action="adminProfile.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="id" class="form-label">ID</label>
                                <input type="text" class="form-control" id="id" name="id" value="<?php echo htmlspecialchars($id); ?>" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($admin['username'] ?? ''); ?>">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($admin['email'] ?? ''); ?>">
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
                            </div>

                            <button type="submit" class="btn btn-primary">Save Updates</button>
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
