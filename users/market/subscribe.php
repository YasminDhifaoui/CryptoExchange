<?php
session_start();
require_once('../../config/config.php');

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Initialize feedback message
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    try {
        // Check if the email is already subscribed
        $stmt = $pdo->prepare("SELECT * FROM web_subscriber WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            $message = "You are already subscribed.";
        } else {
            // Insert the new subscriber's email
            $stmt = $pdo->prepare("INSERT INTO web_subscriber (email, status) VALUES (?, 1)");
            if ($stmt->execute([$email])) {
                $message = "Thank you for subscribing!";
            } else {
                $message = "There was a problem subscribing you.";
            }
        }
    } catch (Exception $e) {
        $message = "An error occurred: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include '../includes/title.php'; ?>
    <link rel="stylesheet" href="../app/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../app/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="../assets/font/risebot.css">
    <link rel="stylesheet" href="../assets/font/font-awesome.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="../app/dist/app.css">
    <style>
        .container button[type="submit"] {
            background-color: black;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .container button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php include_once '../includes/nav.php'; ?>
<br>
    <section class="page-title"> 
        <div class="container">
            <!-- Subscription Form -->
            <form method="post" action="">
                <label for="email">Subscribe to our newsletter:</label>
                <input type="email" name="email" id="email" placeholder="type your email" required><br> 
                <button type="submit">Subscribe</button>
            </form>

            <!-- Feedback Message -->
            <?php if (!empty($message)): ?>
                <div class="alert alert-info mt-3">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include_once '../includes/footer.php'; ?>

    <!-- Scripts -->
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
    <script src="../app/js/plugin.js"></script>
    <script src="../app/js/donatProgress.js"></script> 
</body>
</html>
