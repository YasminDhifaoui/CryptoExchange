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
    <section class="tf-section token">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="tf-title" data-aos="fade-up" data-aos-duration="800">
                            
                            <div class="total_token">
                                <h6>Total Supply: <span>15,000,000</span></h6>
                                <h6>Current Price:  <span>$0.24</span></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="content-progress-box">
                            <div class="content-progress-box">
                                <div class="progress-bar" data-percentage="27.3%">
                                    <p class="progress-title-holder">
                                        <span class="progress-title">Farming Pool</span>
                                        <span class="progress-number-wrapper">
                                            <span class="progress-number-mark">
                                                <span class="percent"></span>
                                            </span>
                                        </span>
                                    </p>
                                    <div class="progress-content-outter">
                                        <div class="progress-content"></div>
                                    </div>
                                </div>
                                <div class="progress-bar" data-percentage="15.3%">
                                    <p class="progress-title-holder">
                                        <span class="progress-title">Staking</span>
                                        <span class="progress-number-wrapper">
                                            <span class="progress-number-mark">
                                                <span class="percent"></span>
                                            </span>
                                        </span>
                                    </p>
                                    <div class="progress-content-outter">
                                        <div class="progress-content"></div>
                                    </div>
                                </div>
                                <div class="progress-bar" data-percentage="07.5%">
                                    <p class="progress-title-holder">
                                        <span class="progress-title">Ecosystem</span>
                                        <span class="progress-number-wrapper">
                                            <span class="progress-number-mark">
                                                <span class="percent"></span>
                                            </span>
                                        </span>
                                    </p>
                                    <div class="progress-content-outter">
                                        <div class="progress-content"></div>
                                    </div>
                                </div>
                                <div class="progress-bar" data-percentage="7.03%">
                                    <p class="progress-title-holder">
                                        <span class="progress-title">Advisor</span>
                                        <span class="progress-number-wrapper">
                                            <span class="progress-number-mark">
                                                <span class="percent"></span>
                                            </span>
                                        </span>
                                    </p>
                                    <div class="progress-content-outter">
                                        <div class="progress-content"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="content-progress-box">
                            <div class="content-progress-box">
                                <div class="progress-bar" data-percentage="23.45%">
                                    <p class="progress-title-holder">
                                        <span class="progress-title">Private Sale</span>
                                        <span class="progress-number-wrapper">
                                            <span class="progress-number-mark">
                                                <span class="percent"></span>
                                            </span>
                                        </span>
                                    </p>
                                    <div class="progress-content-outter">
                                        <div class="progress-content"></div>
                                    </div>
                                </div>
                                <div class="progress-bar" data-percentage="13.3%">
                                    <p class="progress-title-holder">
                                        <span class="progress-title">Liquidity</span>
                                        <span class="progress-number-wrapper">
                                            <span class="progress-number-mark">
                                                <span class="percent"></span>
                                            </span>
                                        </span>
                                    </p>
                                    <div class="progress-content-outter">
                                        <div class="progress-content"></div>
                                    </div>
                                </div>
                                <div class="progress-bar" data-percentage="7.03%">
                                    <p class="progress-title-holder">
                                        <span class="progress-title">Marketing</span>
                                        <span class="progress-number-wrapper">
                                            <span class="progress-number-mark">
                                                <span class="percent"></span>
                                            </span>
                                        </span>
                                    </p>
                                    <div class="progress-content-outter">
                                        <div class="progress-content"></div>
                                    </div>
                                </div>
                                <div class="progress-bar" data-percentage="5.3%">
                                    <p class="progress-title-holder">
                                        <span class="progress-title">Team</span>
                                        <span class="progress-number-wrapper">
                                            <span class="progress-number-mark">
                                                <span class="percent"></span>
                                            </span>
                                        </span>
                                    </p>
                                    <div class="progress-content-outter">
                                        <div class="progress-content"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        
        <section class="tf-section technology">
            <div class="container w_1490">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="tf-title" data-aos="fade-right" data-aos-duration="800">
                            <div class="img_technology">
                                <img src="./users/assets/images/common/technology_bg.png" alt="">
                                <img class="coin coin_1" src="./users/assets/images/common/coin1.png" alt="">
                                <img class="coin coin_2" src="./users/assets/images/common/coin2.png" alt="">
                                <img class="coin coin_3" src="./users/assets/images/common/coin3.png" alt="">
                                <img class="coin coin_4" src="./users/assets/images/common/coin4.png" alt="">
                                <img class="coin coin_5" src="./users/assets/images/common/coin5.png" alt="">
                                <img class="coin coin_6" src="./users/assets/images/common/coin6.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="content_technology" data-aos="fade-up" data-aos-duration="800">
                            <div class="tf-title left">
                                <h2 class="title mb20">
                                    Our Blockchain Technology
                                </h2>
                            </div>
                            <p class="sub_technology">Explore the robust and secure technology behind our platform. We leverage cutting-edge blockchain solutions to offer a seamless trading experience.</p>
                            <div class="swiper-container slider-6">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img src="./users/assets/images/common/logo_blockchain_1.png" alt="">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="./users/assets/images/common/logo_blockchain_2.png" alt="">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="./users/assets/images/common/logo_blockchain_3.png" alt="">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="./users/assets/images/common/logo_blockchain_4.png" alt="">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="./users/assets/images/common/logo_blockchain_5.png" alt="">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="./users/assets/images/common/logo_blockchain_6.png" alt="">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="./users/assets/images/common/logo_blockchain_4.png" alt="">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="./users/assets/images/common/logo_blockchain_5.png" alt="">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="./users/assets/images/common/logo_blockchain_6.png" alt="">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="./users/assets/images/common/logo_blockchain_1.png" alt="">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="./users/assets/images/common/logo_blockchain_2.png" alt="">
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="./users/assets/images/common/logo_blockchain_3.png" alt="">
                                    </div>
                                </div>
                                <div class="swiper-pagination pagination_slider-6"></div>
    
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </section>
        
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