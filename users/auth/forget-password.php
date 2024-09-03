<?php 


require_once('../../config/config.php');
require '../../phpmailer/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $row = $stmt->fetch();

    if ($row) {


        $new_password= random_int(100000, 999999);
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE email = :email");
        $stmt->execute(['password' => $hashed_password, 'email' => $email]);
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            
            $mail->Username = 'usermyb@gmail.com';
            $mail->Password = 'nkpv iouw wtkm kvth';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('your_email@gmail.com', 'You password');
            $mail->addAddress($email);
            $mail->Subject = 'Have you forgot your password';
            $mail->Body = "your new password is : $new_password";

            $mail->send();
            header("Location: login.php");
            exit();
        } catch (Exception $e) {
            echo "Failed to send new password. Error: " . $mail->ErrorInfo;
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
    <title>Risebot - Metaverse Web3 IGO Launchpad HTML Template</title>
    <link rel="stylesheet" href="../app/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../app/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="../app/dist/app.css">
    <link rel="stylesheet" href="../assets/font/risebot.css">
    <link rel="stylesheet" href="../app/dist/apexcharts.css">
    <link rel="stylesheet" href="../assets/font/font-awesome.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="../assets/images/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/images/favicon.png">  
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
        
<?php include_once'../includes/header.php';?>
        <!-- end Header -->
        <section class="page-title">
            <div class="overlay"></div> 
        </section>
        <section class="tf-section project-info">
        <div class="container"> 
            <div class="row">
                <div class="col-md-12">
                    <form action="" method="POST">
                        <div class="project-info-form forget-form">
                            <h4 class="title">Forget Password</h4> 
                            <p>enter your email address in the form below and we will send you further instructions on how to reset your password</p>
                            <div class="form-inner"> 
                                <fieldset>
                                    <label >
                                        Email address
                                    </label>
                                    <input type="email" name="email" placeholder="Your email" required>
                                </fieldset> 
                            </div>
                            <div class="bottom">
                                Nevermind. 
                                <a href="login.php">Sign in</a>
                            </div>
                        </div> 

                        <div class="wrap-btn">
                            <button type="submit" class="tf-button style1">
                                Reset password
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
</body>
</html>