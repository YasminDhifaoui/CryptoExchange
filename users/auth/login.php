<?php
require_once('../../config/config.php');
require '../../phpmailer/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

function getClientIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']) && filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        foreach ($ipList as $ip) {
            $ip = trim($ip);
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                return $ip;
            }
        }
    } 
    return filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ?: '127.0.0.0';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM blocklist WHERE ip_mail = :email");
    $stmt->execute(['email' => $email]);
    $isBlocked = $stmt->fetch();

    if ($isBlocked) {
        echo "<span style='color: red;'>Your account has been blocked. Please contact support.</span>";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();

        if ($row) {
            $stored_password = $row['password'];
            $username = $row['username'];
            $user_id = $row['id'];
            $user_email = $row['email'];

            $_SESSION['username'] = $username;  
            $_SESSION['id'] = $user_id;          
            $_SESSION['email'] = $user_email; 

            $logType = 'login';
            $accessTime = date('Y-m-d H:i:s');
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
            $ipAddress = getClientIP();

            $stmt = $pdo->prepare("INSERT INTO user_log (log_type, access_time, user_agent, user_email, ip) VALUES (:log_type, :access_time, :user_agent, :user_email, :ip)");
            $stmt->execute([
                ':log_type' => $logType,
                ':access_time' => $accessTime,
                ':user_agent' => $userAgent,
                ':user_email' => $email,
                ':ip' => $ipAddress
            ]);

            if (password_verify($password, $stored_password)) {
                $two_factor_code = random_int(100000, 999999);
                $sql_update = "UPDATE users SET two_factor_code = :two_factor_code WHERE email = :email";
                $stmt = $pdo->prepare($sql_update);
                if ($stmt->execute(['two_factor_code' => $two_factor_code, 'email' => $email])) {
                    try {
                       $mail = new PHPMailer(true);
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'usermyb@gmail.com';
                        $mail->Password = 'nkpv iouw wtkm kvth';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;

                        $mail->setFrom('your_email@gmail.com', 'Two-Factor Authentication');
                        $mail->addAddress($email);
                        $mail->Subject = 'Your Two-Factor Authentication Code';
                        $mail->Body = "Your 2FA code is: $two_factor_code";

                        $mail->send();
                        header("Location: two_factor.php?username=" . urlencode($username));
                        exit();
                    } catch (Exception $e) {
                        echo "<span style='color: red;'>Failed to send 2FA code. Error: " . $mail->ErrorInfo . "</span>";
                    }
                } else {
                    echo "<span style='color: red;'>Failed to update 2FA code.</span>";
                }
            } else {
                echo "<span style='color: red;'>Invalid email or password.</span>";
            }
        } else {
            echo "<span style='color: red;'>Invalid email or password.</span>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../app/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../app/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="../app/dist/app.css">
    <link rel="stylesheet" href="../assets/font/risebot.css">
    <link rel="stylesheet" href="../app/dist/apexcharts.css">
    <link rel="stylesheet" href="../assets/font/font-awesome.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <?php include_once'../includes/title.php'; ?>
    <link rel="apple-touch-icon-precomposed" href="../../assets/images/favicon.png">  
</head>
<body class="header-fixed inner-page login-page">
    <div class="preloader">
        <div class="clear-loading loading-effect-2">
            <span></span>
        </div>
    </div>
    <div id="wrapper">
        <?php include_once '../includes/header.php' ?> 
        <section class="page-title">
            <div class="overlay"></div> 
        </section>
        <section class="tf-section project-info">
            <div class="container"> 
                <div class="row">
                    <div class="col-md-12">
                        <form action="" method="POST">
                            <div class="project-info-form form-login">
                                <h6 class="title">Login</h6>
                                <h6 class="title show-mobie"><a href="register.php">Register</a></h6>
                                <h6 class="title link"><a href="register.php">Register</a></h6>
                                <p>Enter your credentials to access your account</p>
                                <div class="form-inner"> 
                                    <fieldset>
                                        <label>Email address *</label>
                                        <input type="email" name="email" placeholder="Your email" required>
                                    </fieldset>
                                    <fieldset>
                                        <label>Password *</label>
                                        <input type="password" name="password" placeholder="Your password" required>
                                    </fieldset> 
                                </div>
                                <a href="forget-password.php" class="fogot-pass">Forgot password?</a>
                            </div> 
                            <div class="wrap-btn">
                                <button type="submit" class="tf-button style2">
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <?php include_once '../includes/footer.php';?>
        <script src="../app/js/jquery.min.js"></script>
        <script src="../app/js/bootstrap.min.js"></script>
        <script src="../app/js/swiper-bundle.min.js"></script>
        <script src="../app/js/swiper.js"></script>
        <script src="../app/js/countto.js"></script>
        <script src="../app/js/app.js"></script>
        <script src="../app/js/donatProgress.js"></script> 
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script src="../app/js/jquery.easing.js"></script>
        <script src="../app/js/plugin.js"></script>
        <script src="../app/js/count-down.js"></script>   
    </div>
</body>
</html>
