<?php
require_once('../../config/config.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $two_factor_code = $_POST['two_factor_code'];

    // Check in the users table for the provided username
    $stmt = $pdo->prepare("SELECT id, two_factor_code, email FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $row = $stmt->fetch();

    if ($row) {
        $stored_two_factor_code = $row['two_factor_code'];
        $user_id = $row['id'];
        $user_email = $row['email'];

        $_SESSION['username'] = $username;  
        $_SESSION['id'] = $user_id;          
        $_SESSION['email'] = $user_email; 

        if ($two_factor_code === $stored_two_factor_code) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_email'] = $user_email;

            $updateSql = "UPDATE users SET two_factor_enabled = 1, status = 'active' WHERE username = :username";
            $updateStmt = $pdo->prepare($updateSql);
            if ($updateStmt->execute(['username' => $username])) {
                header('Location: ../profile/acceuil.php');
                exit();
            } else {
                header("Location: two_factor.php?username=$username&message=update_failed");
                exit();
            }
        } else {
            header("Location: two_factor.php?username=$username&message=invalid_code");
            exit();
        }
    } else {
        header('Location: login.php?message=invalid_user');
        exit();
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Authentication</title>
    
    <link rel="stylesheet" href="../app/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../app/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="../assets/font/risebot.css">
    <link rel="stylesheet" href="../assets/font/font-awesome.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="../app/dist/app.css">

    <!-- Custom CSS -->
    <style>
        .form-container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: gray;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-container p {
            font-size: 16px;
            margin-bottom: 10px;
            color: #333;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .form-container label {
            font-weight: bold;
            color: black;
        }

        .form-container input[type="text"], 
        .form-container input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ced4da;
            font-size: 14px;
            color : black;
        }

        .form-container button[type="submit"] {
            background-color: black;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-container button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .form-container img {
            margin-top: 20px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .page-title {
            padding: 40px 0;
            text-align: center;
            color: #fff;
        }
    </style>

    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="../assets/images/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/images/favicon.png">

    <script src="https://code.highcharts.com/highcharts.js"></script>
</head>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const urlParams = new URLSearchParams(window.location.search);
            const message = urlParams.get('message');

            if (message === 'invalid_code') {
                alert('Invalid verification code. Please try again.');
            }

            const username = urlParams.get('username');
            document.querySelector('input[name="username"]').value = username;
        });
    </script>
</head>
<body>
    
<?php include_once '../includes/nav.php'?>
<br><br><br><br><br><br>
<section class="page-title">
    <div class="form-container">
    <h4>Verify Your Login</h4>
    <form action="" method="POST">
        <input type="hidden" name="username">
        <input type="text" name="two_factor_code" required placeholder="2FA Code">
        <button type="submit">Verify</button>
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
<script src="../app/js/plugin.js"></script>
<script src="../app/js/donatProgress.js"></script> 
</body>
</html>
