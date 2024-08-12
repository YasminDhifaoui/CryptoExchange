<?php

require '../config/config.php';

session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php"); 
    exit();
}

$username = $_SESSION['admin_username'];

$sql = 'SELECT * FROM users';
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll();


// Fetch all verification requests
$stmt = $pdo->prepare("SELECT * FROM verifications ");
$stmt->execute();
$verifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Verification Requests</title>
    <link rel="stylesheet" href="../app/bootstrap/css/bootstrap.css">
    <link rel="shortcut icon" href="../assets/images/favicon.ico" />
      <link rel="stylesheet" href="../assets/css/libs.min.css">
      <link rel="stylesheet" href="../assets/css/coinex.css?v=1.0.0">  </head>
       <style>
.styled-table {
    border-collapse: collapse;
    margin: 25px 0;
    font-size: 0.9em;
    font-family: 'Arial', sans-serif;
    width: 100%;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}

.styled-table thead tr {
    background-color: #ffa500; /* Light Orange */
    color: #ffffff; /* White text */
    text-align: left;
}

.styled-table th,
.styled-table td {
    padding: 12px 15px;
}

.styled-table tbody tr {
    background-color: #000000; /* Black background */
    color: #ffffff; /* White text */
    border-bottom: 1px solid #ffffff; /* White border */
}

.styled-table tbody tr:nth-of-type(even) {
    background-color: #000000; /* Black for even rows */
}

.styled-table tbody tr:nth-of-type(odd) {
    background-color: #000000; /* Black for odd rows */
}

.styled-table tbody tr:last-of-type {
    border-bottom: 2px solid #ffa500; /* Light Orange */
}

.styled-table tbody tr.active-row {
    font-weight: bold;
    color: #ffa500; /* Light Orange */
}

</style>
</head>

<body class="sb-nav-fixed">

<?php include_once'../includes/nav.php'; ?>
<?php include_once'../includes/sidebar.php';?>


<main class="main-content">
<div class="container-fluid content-inner pb-0">
    <div class="container">
        <h1>User Verification Requests</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>CIN</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>CIN Picture</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($verifications as $verification): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($verification['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($verification['cin']); ?></td>
                        <td><?php echo htmlspecialchars($verification['first_name']); ?></td>
                        <td><?php echo htmlspecialchars($verification['last_name']); ?></td>
                        <td><a href="../../users/uploads/<?php echo htmlspecialchars($verification['cinpic']); ?>" target="_blank">View CIN</a></td>
                        <td><?php echo htmlspecialchars($verification['verif_status']); ?></td>
                        <td>
                        <?php if ($verification['verif_status'] == 'not verified') : ?>
                            <form action="process_verification.php" method="POST">
                                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($verification['user_id']); ?>">
                                <button type="submit" name="action" value="accept" class="btn btn-success">Accept</button>
                                <button type="submit" name="action" value="refuse" class="btn btn-danger">Refuse</button>
                            </form>
                        <?php endif; ?>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include_once'../includes/footer.php';?>



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
