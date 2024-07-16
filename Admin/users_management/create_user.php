<?php
require '../config/config.php';
include '../../phpmailer/vendor/autoload.php'; 

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
</head>
<meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    
<body class="sb-nav-fixed"> 


<?php include_once'../includes/nav.php'; ?>
<?php include_once'../includes/sidebar.php';?>


<div id="layoutSidenav_content">
<div class="container-fluid px-4">
<h1>Create User</h1>

<form action="" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>

    <label for="lastName">Last Name:</label>
    <input type="text" id="lastName" name="lastName" required><br><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <input type="submit" value="Create User">
</form>

<a href="users_list.php">Go to User List</a>

</div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="../js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="../assets/demo/chart-area-demo.js"></script>
<script src="../assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="../js/datatables-simple-demo.js"></script>
    
</body>
</html>
