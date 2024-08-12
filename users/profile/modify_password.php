<?php

include '../../config/config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = htmlspecialchars($_SESSION['username']);
$id = isset($_SESSION['id']) ? htmlspecialchars($_SESSION['id']) : 'ID not set';
$email = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'Email not set';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($current_password, $user['password'])) {
                $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
                $stmt->execute([':password' => $new_hashed_password, ':id' => $id]);

                echo "Password updated successfully!";
            } else {
                echo "Current password is incorrect!";
            }
        } else {
            echo "User not found!";
        }
    } else {
        echo "New passwords do not match!";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Password</title>

    
    
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
</head>
<body>


<?php include_once '../includes/nav.php'?>

<section class="page-title">
    <div class="form-container">
        <p>ID: <?php echo $id; ?></p>
        <p>Email: <?php echo $email; ?></p>
        <form action="" method="POST">
            <label for="current_password">Current Password:</label>
            <input type="password" name="current_password" id="current_password" required><br/>
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" id="new_password" required><br/>
            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" name="confirm_password" id="confirm_password" required><br/>
            <button type="submit">Change Password</button>
        </form>
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
     <!-- <script src="app/js/countto.js"></script> --> 
     <script src="../app/js/plugin.js"></script>
     <script src="../app/js/donatProgress.js"></script> 
</body>
</html>
