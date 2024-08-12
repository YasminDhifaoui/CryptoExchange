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
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #000000;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        h2 {
            color: #007bff;
        }
        form {
            width: 30%;
            background-color: #000000;
            padding: 20px;
            border: 2px solid #007bff;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
        }
        input[type="text"] {
            width: 90%;
            padding: 10px;
            border: 1px solid #007bff;
            border-radius: 5px;
            background-color: #000000;
            color: white;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 10px;
            background-color: #007bff;
            border: 2px solid #007bff;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
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
    <h2>Two-Factor Authentication</h2>
    <form action="" method="POST">
        <input type="hidden" name="username">
        <input type="text" name="two_factor_code" required placeholder="2FA Code">
        <button type="submit">Verify</button>
    </form>
</body>
</html>
