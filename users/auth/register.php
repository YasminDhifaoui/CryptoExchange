
<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../../config/config.php'; 
include '../../phpmailer/vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $name = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($name) && !empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $verification_token = bin2hex(random_bytes(32));

        // Insert the user
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, created_at, verification_token) VALUES (?, ?, ?, NOW(), ?)");
        $result = $stmt->execute([$name, $email, $hashedPassword, $verification_token]);

        if ($result) {
            $subject = 'verify your account';
            $body = "Hello,\n\nIn order to verify your account, click on this link :\n\n";
            $body .= "http://localhost/Crypto/users/auth/registerToken.php?email=" . urlencode($email) . "&token=$verification_token\n\n";
            $body .= "Thank you,\n\nCrypto";

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
                $_SESSION['success_message'] = 'A verification email has been send to you. check your email.';
            } catch (Exception $e) {
                $_SESSION['error_message'] = 'Error sending a verification email try again';
            }
        } else {
            $_SESSION['error_message'] = 'account creation  error';
        }
    } else {
        $_SESSION['error_message'] = 'All fields must be filled';
    }

    header('Location: register.php');
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Risebot - Metaverse Web3 IGO Launchpad HTML Template</title>
    <link rel="stylesheet" href="../app/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../app/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="../app/dist/app.css">
    <link rel="stylesheet" href="../assets/font/risebot.css">
    <link rel="stylesheet" href="../app/dist/apexcharts.css">
    <link rel="stylesheet" href="../assets/font/font-awesome.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="assets/images/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="assets/images/favicon.png">  
</head>
<body class="header-fixed inner-page login-page">
        <!-- preloade -->
        <div class="preloader">
            <div class="clear-loading loading-effect-2">
            <span></span>
            </div>
        </div>
        <!-- /preload -->
    <div id="wrapper">
        <!-- Header -->
        <?php include_once '../includes/header.php' ?> 
        <!-- end Header -->
        <section class="page-title">
            <div class="overlay"></div> 
        </section>
        
    <section class="tf-section project-info">
        <div class="container"> 
            <div class="row">
                <div class="col-md-12">
                    <?php
                    if (isset($_SESSION['success_message'])) {
                        echo '<p style="color: green;">' . $_SESSION['success_message'] . '</p>';
                        unset($_SESSION['success_message']);
                    }
                
                    if (isset($_SESSION['error_message'])) {
                        echo '<p style="color: red;">' . $_SESSION['error_message'] . '</p>';
                        unset($_SESSION['error_message']);
                    }
                    ?>
                    <form action="register.php" method="POST">
                        <div class="project-info-form form-login style2">
                            <h6 class="title">Register</h6>
                            <h6 class="title show-mobie"><a href="login.php">Login</a></h6>
                            <h6 class="title link"><a href="login.php">Login</a></h6>
                            <p>Welcome to Risebot, please enter your details</p>
                            <div class="form-inner"> 
                                <fieldset>
                                    <label>
                                        Email address *
                                    </label>
                                    <input type="email" name="email" placeholder="Your email" required>
                                </fieldset>
                                <fieldset>
                                    <label>
                                        Username *
                                    </label>
                                    <input type="text" name="username" placeholder="Your username" required>
                                </fieldset>
                                <fieldset>
                                    <label>
                                        Password *
                                    </label>
                                    <input type="password" name="password" placeholder="Your password" required>
                                </fieldset> 
                                <fieldset class="mb19">
                                    <label>
                                        Confirm password *
                                    </label>
                                    <input type="password" name="password2" placeholder="Confirm password" required>
                                </fieldset> 
                                <fieldset class="checkbox"> 
                                    <input type="checkbox" id="checkbox" name="checkbox" >
                                    <label for="checkbox" class="icon"></label>
                                    <label for="checkbox">
                                        I accept the Term of Conditions and Privacy Policy
                                    </label>
                                </fieldset>
                            </div>
                        </div> 

                        <div class="wrap-btn">
                            <button type="submit" class="tf-button style2">
                                Register
                            </button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </section>

    <?php include_once'../includes/footer.php';?>


    <div class="modal fade popup" id="popup_bid" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="close icon" data-dismiss="modal" aria-label="Close">
                    <img src="../../assets/images/backgroup/bg_close.png" alt="">
                </div>
                <div class="header-popup">
                    <h5>Select a Wallet</h5>
                    <div class="desc">
                        By connecting your wallet, you agree to our <a href="#">Terms of Service</a> and our <a href="#">Privacy Policy</a>.
                    </div>
                    <div class="spacing"></div> 
                </div>
                
                <div class="modal-body center">
                    <div class="connect-wallet"> 
                        <ul>
                            <li>
                                <a href="connect-wallet.html"><img src="../../assets/images/common/wallet_5.png" alt="">
                                    <span>MetaMask</span>
                                    <span class="icon">
                                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.1875 1.375L6.8125 7L1.1875 12.625" stroke="#798DA3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg> 
                                    </span>
                                </a>
                            </li>

                            <li>
                                <a href="connect-wallet.html">
                                    <img src="../../assets/images/common/wallet_6.png" alt="">
                                    <span>Coibase Walet</span>
                                    <span class="icon">
                                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.1875 1.375L6.8125 7L1.1875 12.625" stroke="#798DA3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg> 
                                    </span>
                                </a>
                            </li>

                            <li>
                                <a href="connect-wallet.html">
                                    <img src="../../assets/images/common/wallet_7.png" alt="">
                                    <span>WaletConnect</span>
                                    <span class="icon">
                                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.1875 1.375L6.8125 7L1.1875 12.625" stroke="#798DA3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg> 
                                    </span>
                                </a>
                            </li>

                            <li>
                                <a href="connect-wallet.html">
                                    <img src="../../assets/images/common/wallet_8.png" alt="">
                                    <span>Phantom</span>
                                    <span class="icon">
                                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.1875 1.375L6.8125 7L1.1875 12.625" stroke="#798DA3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg> 
                                    </span>
                                </a>
                            </li>

                            <li>
                                <a href="connect-wallet.html">
                                    <img src="../../assets/images/common/wallet_9.png" alt="">
                                    <span>Core</span>
                                    <span class="icon">
                                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.1875 1.375L6.8125 7L1.1875 12.625" stroke="#798DA3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg> 
                                    </span>
                                </a>
                            </li>

                            <li>
                                <a href="#">
                                    <img src="../../assets/images/common/wallet_10.png" alt="">
                                    <span>Bitski</span>
                                    <span class="icon">
                                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1.1875 1.375L6.8125 7L1.1875 12.625" stroke="#798DA3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg> 
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <a id="scroll-top"></a>
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
</body>
</html>
