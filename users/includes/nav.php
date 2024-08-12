<?php
require '../../config/config.php';


if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = htmlspecialchars($_SESSION['username']);
$user_id = isset($_SESSION['id']) ? htmlspecialchars($_SESSION['id']) : 'ID not set';

// Fetch notifications for the user
$stmt = $pdo->prepare("SELECT * FROM notifications WHERE user_id = :user_id ORDER BY created_at DESC");
$stmt->execute([':user_id' => $user_id]);
$notifications = $stmt->fetchAll();

// Count unread notifications
$stmt = $pdo->prepare("SELECT COUNT(*) FROM notifications WHERE user_id = :user_id AND status = 'unread'");
$stmt->execute([':user_id' => $user_id]);
$unread_count = $stmt->fetchColumn();

// Mark notifications as read
$stmt = $pdo->prepare("UPDATE notifications SET status = 'read' WHERE user_id = :user_id AND status = 'unread'");
$stmt->execute([':user_id' => $user_id]);
?>


<style>/* Add this CSS to your existing styles */
.notification-count {
    display: inline-block;
    background-color: red;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    text-align: center;
    line-height: 20px;
    font-size: 12px;
    font-weight: bold;
    position: relative;
    top: -10px;
    left: -10px;
}</style>


<header id="header_main" class="header">
    <div class="container">
        <div id="site-header-inner">
            <!--<div class="header__logo">
                <a href="index.html"><img src="assets/images/logo/logo.png" alt=""></a>
            </div>-->
            <nav id="main-nav" class="main-nav">
                <ul id="menu-primary-menu" class="menu">
                    <li class="menu-item">
                        <a href="../profile/acceuil.php">Home</a>
                    </li>
                    <li class="menu-item">
                        <a href="../profile/notifications.php">Notification
                        <?php if ($unread_count > 0): ?>
                                <span class="notification-count"><?php echo $unread_count; ?></span>
                            <?php endif; ?>

                        </a>
                    </li>
                    <li class="menu-item menu-item-has-children">
                        <a href="#">Markets</a>
                        <ul class="sub-menu">
                            <li class="menu-item"><a href="market-overview.html">Market Overview</a></li>
                            <li class="menu-item"><a href="top-gainers.html">Top Gainers</a></li>
                            <li class="menu-item"><a href="top-losers.html">Top Losers</a></li>
                            <li class="menu-item"><a href="market-details.html">Market Details</a></li>
                        </ul>
                    </li>
                    <li class="menu-item menu-item-has-children">
                        <a href="#">Wallets</a>
                        <ul class="sub-menu">
                            <li class="menu-item"><a href="wallet-overview.html">Wallet Overview</a></li>
                            <li class="menu-item"><a href="wallet-transactions.html">Transactions</a></li>
                            <li class="menu-item"><a href="wallet-settings.html">Wallet Settings</a></li>
                        </ul>
                    </li>
                    <li class="menu-item menu-item-has-children">
                        <a href="#">Trade</a>
                        <ul class="sub-menu">
                            <li class="menu-item"><a href="trade-spot.html">Spot Trading</a></li>
                            <li class="menu-item"><a href="trade-margin.html">Margin Trading</a></li>
                            <li class="menu-item"><a href="trade-futures.html">Futures Trading</a></li>
                        </ul>
                    </li>
                    <li class="menu-item menu-item-has-children">
                        <a href="#">Portfolio</a>
                        <ul class="sub-menu">
                            <li class="menu-item"><a href="portfolio-overview.html">Portfolio Overview</a></li>
                            <li class="menu-item"><a href="portfolio-performance.html">Performance</a></li>
                        </ul>
                    </li>
                    
                    <li class="menu-item menu-item-has-children">
                        <a href="#">Account</a>
                        <ul class="sub-menu">
                            <li class="menu-item"><a href="../profile/verify.php">Verify</a></li>
                            <li class="menu-item"><a href="../profile/modify_password.php">Change password</a></li>
                            <li class="menu-item"><a href="../auth/logout.php">Logout</a></li>
                        </ul>
                    </li>
                    <li>
                    <a href="#" data-toggle="modal" data-target="#popup_bid" class="tf-button style1">
                Connect Wallet
            </a>
            <div class="mobile-button"><span></span></div><!-- /.mobile-button -->
                    </li>
                </ul>
            </nav><!-- /#main-nav -->
            
        </div>
    </div>
</header>


