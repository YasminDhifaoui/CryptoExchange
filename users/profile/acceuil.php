<?php
session_start();
if (!isset($_SESSION['username'])) {

    header('Location: login.php');
    exit();
}
$username = htmlspecialchars($_SESSION['username']);
$id = isset($_SESSION['id']) ? htmlspecialchars($_SESSION['id']) : 'ID not set';
$email = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'Email not set';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once '../includes/title.php';  ?>
    
</head>
<link rel="stylesheet" href="../app/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../app/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="../assets/font/risebot.css">
    <link rel="stylesheet" href="../assets/font/font-awesome.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="../app/dist/app.css">

    <body>
    
<?php include_once '../includes/nav.php'?>


<section class="page-title"> 
    <div class="message">
        <h4>Welcome, <?php echo $username; ?> !</h4>
        <p>Your account has been verified !</p>
        
    </div>
    </section>
    
<?php include_once '../includes/footer.php'?>


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
     <!-- <script src="../app/js/countto.js"></script> --> 
     <script src="../app/js/plugin.js"></script>
     <script src="../app/js/donatProgress.js"></script> 
</body>
</html>