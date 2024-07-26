<?php
require '../config/config.php';
include '../../phpmailer/vendor/autoload.php'; 

session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php"); 
    exit();
}

$username = $_SESSION['admin_username'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $lastname = $_POST['lastName']; // Ensure consistency

    if (!empty($email) && !empty($username) && !empty($lastname)) {
        $password = random_int(100000, 999999);
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("INSERT INTO users (username, lastName, email, password) VALUES (?, ?, ?, ?)");
        $result = $stmt->execute([$username, $lastname, $email, $hashedPassword]);

        if ($result) {
            $subject = 'Your Account has been created by Admin, verify your account';
            $body = "Hello,\n\nEmail: $email\nPassword: $password\n\n";
            $body .= "In order to verify your account, click on this link:\n";
            $body .= "http://localhost/Crypto/users/auth/login.php\n\n";
            $body .= "Thank you,\nCrypto";

            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; 
                $mail->SMTPAuth = true;
                
                $mail->Username = 'usermyb@gmail.com'; 
                $mail->Password = 'nkpv iouw wtkm kvth'; 
                
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('usermyb@gmail.com', 'Mohamed Yassine');
                $mail->addAddress($email);

                $mail->isHTML(false);
                $mail->Subject = $subject;
                $mail->Body = $body;

                $mail->send();
                $_SESSION['success_message'] = 'A verification email has been sent to the user.';
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Error sending a verification email, please try again.';
            }
        } else {
            $_SESSION['error_message'] = 'Account creation error.';
        }
    } else {
        $_SESSION['error_message'] = 'All fields must be filled.';
    }

    header('Location: users_list.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
    <link rel="shortcut icon" href="../assets/images/favicon.ico" />
    <link rel="stylesheet" href="../assets/css/libs.min.css">
    <link rel="stylesheet" href="../assets/css/coinex.css?v=1.0.0">
    <style>
        .form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .form-container h1 {
            margin-bottom: 20px;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
        }

        .form-container label {
            margin-bottom: 8px;
            font-weight: bold;
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .form-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .form-container input[type="submit"]:hover {
            background-color: #45a049;
        }

        .form-container a {
            display: inline-block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }

        .form-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body class="sb-nav-fixed">
    <?php include_once '../includes/nav.php'; ?>
    <?php include_once '../includes/sidebar.php'; ?>

    <main class="main-content">
        <div class="container-fluid content-inner pb-0">
            <div class="form-container">
                <h1>Create User</h1>
                <form action="" method="post">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required><br>

                    <label for="lastName">Last Name:</label>
                    <input type="text" id="lastName" name="lastName" required><br>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required><br>

                    <input type="submit" value="Create User">
                </form>

                <a href="users_list.php">Go to User List</a>
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
