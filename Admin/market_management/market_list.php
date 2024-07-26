<?php
require '../config/config.php';


session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php"); 
    exit();
}

$username = $_SESSION['admin_username'];

$sql = 'SELECT * FROM market';
$stmt = $pdo->query($sql);
$markets = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MArket List</title>
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
    background-color: #ffa500; 
    color: #ffffff; 
    text-align: left;
}

.styled-table th,
.styled-table td {
    padding: 12px 15px;
}

.styled-table tbody tr {
    background-color: #000000; 
    color: #ffffff; 
    border-bottom: 1px solid #ffffff; 
}

.styled-table tbody tr:nth-of-type(even) {
    background-color: #000000; 
}

.styled-table tbody tr:nth-of-type(odd) {
    background-color: #000000; 
}

.styled-table tbody tr:last-of-type {
    border-bottom: 2px solid #ffa500; 
}

.styled-table tbody tr.active-row {
    font-weight: bold;
    color: #ffa500; 
}

</style>
    
</head>
<body class="sb-nav-fixed">

<?php include_once'../includes/nav.php'; ?>
<?php include_once'../includes/sidebar.php';?>


<main class="main-content">
<div class="container-fluid content-inner pb-0">


<img src="../uploads/market.png" width=70px  ><br> <br><br> <br>

<a href="create_market.php"><img src="../uploads/crud/add.png" width=30px style="border-radius:100px;">Add market
<table class="styled-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Full Name</th>
            <th>Symbol</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($markets) > 0): ?>
            <?php foreach ($markets as $market): ?>
                <tr>
                    <td><?php echo htmlspecialchars($market['id']); ?></td>
                    <td><?php echo htmlspecialchars($market['name']); ?></td>
                    <td><?php echo htmlspecialchars($market['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($market['symbol']); ?></td>
                    <td><?php echo htmlspecialchars($market['status']); ?></td>
                    <td>
                        <a href="edit_market.php?id=<?php echo $market['id']; ?>">Edit</a>


                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No markets found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
        </div>
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
