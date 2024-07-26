<?php
require '../config/config.php';

session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php"); 
    exit();
}

$username = $_SESSION['admin_username'];

$sql = 'SELECT * FROM admin';
$stmt = $pdo->query($sql);
$admins = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin List</title>
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


<img src="../uploads/Admin.png" width=70px  style="border-radius:1000%;"><br> <br><br> <br>

<table class="styled-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Created_at</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($admins) > 0): ?>
            <?php foreach ($admins as $admin): ?>
                <tr>
                    <td><?php echo htmlspecialchars($admin['id']); ?></td>
                    <td><?php echo htmlspecialchars($admin['username']); ?></td>
                    <td><?php echo htmlspecialchars($admin['email']); ?></td>
                    <td><?php echo htmlspecialchars($admin['created_at']); ?></td>
                    <td>
                        <a href="edit_admin.php?id=<?php echo $admin['id']; ?>">Edit</a>
                        <a href="delete_admin.php?id=<?php echo $admin['id']; ?>" onclick="return confirm('Are you sure you want to delete this admin?');">Delete</a>
                        

                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No admins found.</td>
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
