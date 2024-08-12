<?php
require '../../config/config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = htmlspecialchars($_SESSION['username']);
$user_id = isset($_SESSION['id']) ? htmlspecialchars($_SESSION['id']) : 'ID not set';

// Fetch notifications for the user
$stmt = $pdo->prepare("SELECT * FROM notifications WHERE user_id = :user_id ORDER BY created_at DESC");
$stmt->execute([':user_id' => $user_id]);
$notifications = $stmt->fetchAll();

// Count unread notifications
$stmt = $pdo->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = :user_id AND status = 'unread'");
$stmt->execute([':user_id' => $user_id]);
$unread_count = $stmt->fetchColumn();

// Mark notifications as read
$stmt = $pdo->prepare("UPDATE notifications SET status = 'read' WHERE user_id = :user_id AND status = 'unread'");
$stmt->execute([':user_id' => $user_id]);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
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
        .styled-table {
            border-collapse: collapse;
            margin: 25px auto; /* Center table horizontally */
            font-size: 0.9em;
            font-family: 'Arial', sans-serif;
            width: 80%; /* Adjust the width as needed */
            border: 1px solid ; /* Border around the entire table */
        }

        .styled-table th,
        .styled-table td {
            padding: 12px 15px;
            border: 1px solid ; /* Add border to table cells */
        }

        .styled-table thead tr {
            text-align: left;
        }

        .styled-table tbody tr:last-of-type {
            border-bottom: 2px solid ; /* Border at the bottom of the last row */
        }

        .styled-table tbody tr.active-row {
            font-weight: bold;
            
        }
    </style>
</head>
<body>
    <?php include_once '../includes/nav.php'; ?>

    <section class="page-title">
        <main class="main-content">
            <div class="container-fluid content-inner pb-0">
                <table class="styled-table">
                    
                    <tbody>
                        <?php if (count($notifications) > 0): ?>
                            <?php foreach ($notifications as $notification): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($notification['message']); ?></td>
                                    <td><?php echo htmlspecialchars($notification['created_at']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No notifications.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
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
