<?php
require '../config/config.php';

session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php"); 
    exit();
}

$username = $_SESSION['admin_username'];

$stmt = $pdo->prepare("SELECT * FROM blocklist");
$stmt->execute();
$blocklist = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once '../includes/title.php'; ?>
    <link rel="stylesheet" href="../assets/css/libs.min.css">
    <link rel="stylesheet" href="../assets/css/coinex.css?v=1.0.0">
    
<style>
/* Styled Table */
.styled-table {
    border-collapse: collapse;
    margin: 25px 0;
    font-size: 0.9em;
    font-family: 'Arial', sans-serif;
    width: 100%;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}

.styled-table thead tr {
    background-color: #ffa500;
    color: #ffffff;
    text-align: left;
}

.styled-table th, .styled-table td {
    padding: 12px 15px;
}

.styled-table tbody tr {
    background-color: #000000;
    color: #ffffff;
    border-bottom: 1px solid #ffffff;
}

.styled-table tbody tr:last-of-type {
    border-bottom: 2px solid #ffa500;
}
    
    </style>
</head>

<body class="sb-nav-fixed">
<?php include_once '../includes/nav.php'; ?>
<?php include_once '../includes/sidebar.php'; ?>


<main class="main-content">
    <div class="container-fluid content-inner pb-0">
        <img src="../uploads/Users.png" width="90px"><br><br><br><br>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($blocklist as $entry): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($entry['id']); ?></td>
                        <td><?php echo htmlspecialchars($entry['ip_mail']); ?></td>
                        <td>
                            <a href="unblock.php?id=<?php echo htmlspecialchars($entry['id']); ?>" class="btn btn-warning btn-sm">Unblock</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    
    </div>
</main>

<?php include_once '../includes/footer.php'; ?>

<script src="../assets/js/libs.min.js"></script>
<script src="../assets/js/app.js"></script>
</body>
</html>
