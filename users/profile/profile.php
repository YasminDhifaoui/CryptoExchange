<?php
include '../../config/config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
$stmt->execute([':user_id' => $_SESSION['id']]);
$user = $stmt->fetch();


$sql = 'SELECT * FROM verifications WHERE user_id = :user_id';
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $_SESSION['id']]);
$verification = $stmt->fetch();


$sql = 'SELECT * FROM user_log WHERE user_email = :user_email ORDER BY access_time DESC';
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_email' => $user['email']]);
$userLogs = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>

    

    <link rel="stylesheet" href="../app/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../app/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="../assets/font/risebot.css">
    <link rel="stylesheet" href="../assets/font/font-awesome.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="../app/dist/app.css">

    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="../assets/images/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/images/favicon.png">

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <style>
        .profile-info p {
            margin: 0;
            padding: 5px 0;
        }
        table.table {
            background-color: gray;
            border-radius:20px;
        }
        .btn-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<?php include_once '../includes/nav.php'; ?>
<br><br><br><br><br><br><br>

<section class="container">
    <div class="row">
        <div class="col-md-4">

        <svg xmlns="http://www.w3.org/2000/svg" width="150" height="200" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
        <path d="M8 8a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a5.978 5.978 0 0 0-4.979 2.672C2.465 12.964 3.5 14 5 14h6c1.5 0 2.535-1.036 1.979-2.328A5.978 5.978 0 0 0 8 9z"/>
        </svg>


            <div class="profile-info">
                <p><strong>ID:</strong> <?php echo htmlspecialchars($user['id']); ?></p>
                <p><strong>Status:</strong> <?php echo htmlspecialchars($user['status']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user['lastName']); ?></p>
                <p><strong>Created At:</strong> <?php echo htmlspecialchars($user['created_at']); ?></p>

                <p><strong>Status (verification):</strong> <?php echo htmlspecialchars($verification['verif_status']); ?></p>
            
            </div>

            <!-- Buttons -->
            <div class="btn-container">
                <a href="verify.php" class="btn btn-primary">Verify</a>
                <a href="modify_password.php" class="btn btn-secondary">Change Password</a>
            </div>
        </div>

        
        <div class="col-md-8">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Access Time</th>
                        <th>Log Type</th>
                        <th>User Agent</th>
                        <th>User Email</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($userLogs as $log): ?>
                        <tr>
                            
                        <td><?php echo htmlspecialchars($log['access_time']); ?></td>
                            <td><?php echo htmlspecialchars($log['log_type']); ?></td>
                            <td><?php echo htmlspecialchars($log['user_agent']); ?></td>
                            
                            <td><?php echo htmlspecialchars($log['user_email']); ?></td>
                            <td><?php echo htmlspecialchars($log['ip']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<script src="../app/js/jquery.min.js"></script>
<script src="../app/js/bootstrap.min.js"></script>
<script src="../app/js/swiper-bundle.min.js"></script>
<script src="../app/js/swiper.js"></script>
<script src="../app/js/jquery.easing.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="../app/js/parallax.js"></script>
<script src="../app/js/jquery.magnific-popup.min.js"></script>
<script src="../app/js/app.js"></script>
<script src="../app/js/count-down.js"></script>
<script src="../app/js/plugin.js"></script>
<script src="../app/js/donatProgress.js"></script> 

</body>
</html>
