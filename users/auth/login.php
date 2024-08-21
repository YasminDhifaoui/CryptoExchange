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
                    echo "Failed to send 2FA code. Error: " . $mail->ErrorInfo;
                }
            } else {
                echo "Failed to update 2FA code.";
            }
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "Invalid email or password.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../app/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../app/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="../app/dist/app.css">
    <link rel="stylesheet" href="../assets/font/risebot.css">
    <link rel="stylesheet" href="../app/dist/apexcharts.css">
    <link rel="stylesheet" href="../assets/font/font-awesome.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="../../assets/images/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="../../assets/images/favicon.png">  
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
                    

                    <form action="" method="POST">
                        <div class="project-info-form form-login">
                            <h6 class="title">Login</h6>
                            <h6 class="title show-mobie"><a href="register.php">Register</a></h6>
                            <h6 class="title link"><a href="register.php">Register</a></h6>
                            <p>Enter your credentials to access your account</p>
                            <div class="form-inner"> 
                                <fieldset>
                                    <label>
                                        Email address *
                                    </label>
                                    <input type="email" name="email" placeholder="Your email" required>
                                </fieldset>
                                <fieldset>
                                    <label>
                                        Password *
                                    </label>
                                    <input type="password" name="password" placeholder="Your password" required>
                                </fieldset> 
                            </div>
                            <a href="forget-password.php" class="fogot-pass">Fogot password?</a>
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

    <section class="tf-section tf_CTA">

        <div class="container relative">
            <div class="overlay">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="tf-title left mt56" data-aos="fade-up" data-aos-duration="800">
                        <h2 class="title">
                            Launch on Risebot
                        </h2>
                        <p class="sub">Full support in project incubation</p>
                        <div class="wrap-btn">
                            <a href="submit-IGO-on-chain.html" class="tf-button style3">
                                Apply Now
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                  <div class="image_cta" data-aos="fade-left" data-aos-duration="1200">
                    <img class="move4" src="../../assets/images/common/img_cta.png" alt="">
                  </div>
                </div>
            </div>
        </div>
    </section>

    <?php include_once '../../includes/footer.php' ?> 

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