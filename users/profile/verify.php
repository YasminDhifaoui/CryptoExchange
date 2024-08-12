<?php

include '../../config/config.php';
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = htmlspecialchars($_SESSION['username']);
$id = isset($_SESSION['id']) ? htmlspecialchars($_SESSION['id']) : 'ID not set';
$email = isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : 'Email not set';

// Check verification status
$stmt = $pdo->prepare("SELECT * FROM verifications WHERE user_id = :user_id");
$stmt->execute([':user_id' => $id]);
$verification = $stmt->fetch();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $cin = htmlspecialchars($_POST['cin']);
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $status = 'not verified';

    // File upload handling
    if (isset($_FILES['cin_picture']) && $_FILES['cin_picture']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['cin_picture']['tmp_name'];
        $fileName = $_FILES['cin_picture']['name'];
        $fileSize = $_FILES['cin_picture']['size'];
        $fileType = $_FILES['cin_picture']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Sanitize the file name
        $newFileName = $id . '_cin.' . $fileExtension;

        // Directory in which to save the file
        $uploadFileDir = '../uploads/';
        $dest_path = $uploadFileDir . $newFileName;

        // Allow certain file formats
        $allowedfileExtensions = array('jpg', 'jpeg', 'png', 'pdf');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            if ($fileSize < 5242880) { // 5MB limit
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $stmt = $pdo->prepare("INSERT INTO verifications (user_id, cin, first_name, last_name, cinpic, verif_status) VALUES (:user_id, :cin, :first_name, :last_name, :cin_picture, :status)");
                    $stmt->execute([
                        ':user_id' => $id,
                        ':cin' => $cin,
                        ':first_name' => $first_name,
                        ':last_name' => $last_name,
                        ':cin_picture' => $newFileName,
                        ':status' => $status
                    ]);

                    echo "Verification details submitted successfully!";
                } else {
                    echo "There was an error moving the uploaded file.";
                }
            } else {
                echo "File size exceeds the 5MB limit.";
            }
        } else {
            echo "Upload failed. Allowed file types: " . implode(',', $allowedfileExtensions);
        }
    } else {
        echo "No file uploaded or there was an upload error.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Verification</title>

    <link rel="stylesheet" href="../app/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../app/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="../assets/font/risebot.css">
    <link rel="stylesheet" href="../assets/font/font-awesome.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="../app/dist/app.css">

    <!-- Favicon and Touch Icons  -->
    <link rel="shortcut icon" href="../assets/images/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/images/favicon.png">

    <script src="https://code.highcharts.com/highcharts.js"></script>
</head>
<body>

<?php include_once '../includes/nav.php'?>

<section class="page-title">
    <div class="form-container">
        <?php if ($verification && $verification['verif_status'] == 'Accepted'): ?>
            <!-- Show user information -->
            <p><strong>ID:</strong> <?php echo $id; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
            <p><strong>CIN:</strong> <?php echo htmlspecialchars($verification['cin']); ?></p>
            <p><strong>First Name:</strong> <?php echo htmlspecialchars($verification['first_name']); ?></p>
            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($verification['last_name']); ?></p>
            <p><strong>Status (verification):</strong> <?php echo htmlspecialchars($verification['verif_status']); ?></p>
            <img width="200px" src="../uploads/<?php echo htmlspecialchars($verification['cinpic']); ?>" alt="CIN Picture">
        <?php else: ?>
            <!-- Show the verification form -->
            <p><strong>ID:</strong> <?php echo $id; ?></p>
            <p><strong>Email:</strong> <?php echo $email; ?></p>
            <form action="" method="POST" enctype="multipart/form-data">
                <label for="cin">CIN:</label>
                <input type="text" name="cin" id="cin" required><br/>
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="first_name" required><br/>
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="last_name" required><br/>
                <label for="cin_picture">CIN Picture:</label>
                <input type="file" name="cin_picture" id="cin_picture" accept=".jpg,.jpeg,.png,.pdf" required><br/>
                <button type="submit">Submit Verification</button>
            </form>
        <?php endif; ?>
    </div>
</section>

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
