<?php
require_once('../config/config.php');
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['admin_username'];

// Fetch settings from the database before processing the form
try {
    $stmt = $pdo->prepare("SELECT * FROM setting");
    $stmt->execute();
    $setting = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error fetching settings: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $uploadDir = '../uploads/';

    // For logo
    $logo = $setting['logo']; // Keep existing value
    if (!empty($_FILES['logo']['tmp_name'])) {
        $logoPath = $uploadDir . basename($_FILES['logo']['name']);
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $logoPath)) {
            $logo = $logoPath; // Update only if a new file was uploaded
        } else {
            $error = "Error uploading logo.";
        }
    }

    // For logo_web
    $logo_web = $setting['logo_web']; // Keep existing value
    if (!empty($_FILES['logo_web']['tmp_name'])) {
        $logoWebPath = $uploadDir . basename($_FILES['logo_web']['name']);
        if (move_uploaded_file($_FILES['logo_web']['tmp_name'], $logoWebPath)) {
            $logo_web = $logoWebPath; // Update only if a new file was uploaded
        } else {
            $error = "Error uploading logo_web.";
        }
    }

    // For favicon
    $favicon = $setting['favicon']; // Keep existing value
    if (!empty($_FILES['favicon']['tmp_name'])) {
        $faviconPath = $uploadDir . basename($_FILES['favicon']['name']);
        if (move_uploaded_file($_FILES['favicon']['tmp_name'], $faviconPath)) {
            $favicon = $faviconPath; // Update only if a new file was uploaded
        } else {
            $error = "Error uploading favicon.";
        }
    }

    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $siteDescription = $_POST['siteDescription'] ?? '';
    $sitekeywords = $_POST['sitekeywords'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $language = $_POST['language'] ?? '';
    $site_align = $_POST['site_align'] ?? '';
    $footer_text = $_POST['footer_text'] ?? '';
    $time_zone = $_POST['time_zone'] ?? '';
    $latitude = $_POST['latitude'] ?? '';
    $office_time = $_POST['office_time'] ?? '';
    $show_trademenu_without_verify = $_POST['show_trademenu_without_verify'] ?? 1;
    $email_verify = $_POST['email_verify'] ?? 0;
    $phone_verify = $_POST['phone_verify'] ?? 0;
    $kyc_verify = $_POST['kyc_verify'] ?? 0;
    $update_notification = $_POST['update_notification'] ?? '';

    try {
        $sql = "UPDATE setting SET 
                title = :title, 
                description = :description, 
                siteDescription = :siteDescription, 
                sitekeywords = :sitekeywords, 
                email = :email, 
                phone = :phone, 
                logo = :logo, 
                logo_web = :logo_web, 
                favicon = :favicon, 
                language = :language, 
                site_align = :site_align, 
                footer_text = :footer_text, 
                time_zone = :time_zone, 
                latitude = :latitude, 
                office_time = :office_time, 
                show_trademenu_without_verify = :show_trademenu_without_verify, 
                email_verify = :email_verify, 
                phone_verify = :phone_verify, 
                kyc_verify = :kyc_verify, 
                update_notification = :update_notification";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':siteDescription', $siteDescription, PDO::PARAM_STR);
        $stmt->bindParam(':sitekeywords', $sitekeywords, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':logo', $logo, PDO::PARAM_STR);
        $stmt->bindParam(':logo_web', $logo_web, PDO::PARAM_STR);
        $stmt->bindParam(':favicon', $favicon, PDO::PARAM_STR);
        $stmt->bindParam(':language', $language, PDO::PARAM_STR);
        $stmt->bindParam(':site_align', $site_align, PDO::PARAM_STR);
        $stmt->bindParam(':footer_text', $footer_text, PDO::PARAM_STR);
        $stmt->bindParam(':time_zone', $time_zone, PDO::PARAM_STR);
        $stmt->bindParam(':latitude', $latitude, PDO::PARAM_STR);
        $stmt->bindParam(':office_time', $office_time, PDO::PARAM_STR);
        $stmt->bindParam(':show_trademenu_without_verify', $show_trademenu_without_verify, PDO::PARAM_INT);
        $stmt->bindParam(':email_verify', $email_verify, PDO::PARAM_INT);
        $stmt->bindParam(':phone_verify', $phone_verify, PDO::PARAM_INT);
        $stmt->bindParam(':kyc_verify', $kyc_verify, PDO::PARAM_INT);
        $stmt->bindParam(':update_notification', $update_notification, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: appSetting.php?status=success");
        exit;
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once '../includes/title.php';?>
    <link rel="stylesheet" href="../assets/css/libs.min.css">
    <link rel="stylesheet" href="../assets/css/coinex.css?v=1.0.0">  
</head>
<body class="sb-nav-fixed">

<?php include_once '../includes/nav.php'; ?>
<?php include_once '../includes/sidebar.php';?>

<main class="main-content">
    <div class="container-fluid content-inner pb-0">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
            <div class="alert alert-success">
                Settings updated successfully!
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Application Settings</h5>
                    </div>
                    <div class="card-body">
                        <form action="appSetting.php" method="post" enctype="multipart/form-data">
                            <?php foreach ([
                                'title', 'description', 'siteDescription', 'sitekeywords', 'email',
                                'phone', 'site_align',
                                'footer_text', 'time_zone', 'latitude', 'office_time','update_notification'
                            ] as $field): ?>
                                <div class="mb-3">
                                    <label for="<?php echo htmlspecialchars($field); ?>" class="form-label"><?php echo ucfirst(str_replace('_', ' ', $field)); ?></label>
                                    <input type="text" class="form-control" id="<?php echo htmlspecialchars($field); ?>" name="<?php echo htmlspecialchars($field); ?>" value="<?php echo htmlspecialchars($setting[$field] ?? ''); ?>">
                                </div>
                            <?php endforeach; ?>

                            <div class="mb-3">
                                <label for="language" class="form-label">Language</label>
                                <select class="form-control" id="language" name="language">
                                    <option value="eng" <?php echo $setting['language'] === 'eng' ? 'selected' : ''; ?>>English</option>
                                    <option value="fr" <?php echo $setting['language'] === 'fr' ? 'selected' : ''; ?>>French</option>
                                    <option value="arb" <?php echo $setting['language'] === 'arb' ? 'selected' : ''; ?>>Arabic</option>
                                    <option value="esp" <?php echo $setting['language'] === 'esp' ? 'selected' : ''; ?>>Spanish</option>
                                </select>
                            </div>


                                <div class="mb-3">
                                    <label for="email_verify" class="form-label">Show trade menu</label>
                                    <select class="form-control" id="show_trademenu_without_verify" name="show_trademenu_without_verify">
                                        <option value="0" <?php echo $setting['show_trademenu_without_verify'] == 0 ? 'selected' : ''; ?>>Yes</option>
                                        <option value="1" <?php echo $setting['show_trademenu_without_verify'] == 1 ? 'selected' : ''; ?>>No</option>
                                    </select>
                                </div>    

                                <div class="mb-3">
                                    <label for="email_verify" class="form-label">Email Verification</label>
                                    <select class="form-control" id="email_verify" name="email_verify">
                                        <option value="0" <?php echo $setting['email_verify'] == 0 ? 'selected' : ''; ?>>Not Required</option>
                                        <option value="1" <?php echo $setting['email_verify'] == 1 ? 'selected' : ''; ?>>Required</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="phone_verify" class="form-label">Phone Verification</label>
                                    <select class="form-control" id="phone_verify" name="phone_verify">
                                        <option value="0" <?php echo $setting['phone_verify'] == 0 ? 'selected' : ''; ?>>Not Required</option>
                                        <option value="1" <?php echo $setting['phone_verify'] == 1 ? 'selected' : ''; ?>>Required</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="kyc_verify" class="form-label">KYC Verification</label>
                                    <select class="form-control" id="kyc_verify" name="kyc_verify">
                                        <option value="0" <?php echo $setting['kyc_verify'] == 0 ? 'selected' : ''; ?>>Not Required</option>
                                        <option value="1" <?php echo $setting['kyc_verify'] == 1 ? 'selected' : ''; ?>>Required</option>
                                    </select>
                                </div>


                            <div class="mb-3">
                                <label for="logo" class="form-label">Logo</label>
                                <input type="file" class="form-control" id="logo" name="logo">
                                <?php if (!empty($setting['logo'])): ?>
                                    Current: <?php echo htmlspecialchars($setting['logo']); ?>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label for="logo_web" class="form-label">Logo (Web)</label>
                                <input type="file" class="form-control" id="logo_web" name="logo_web">
                                <?php if (!empty($setting['logo_web'])): ?>
                                    Current: <?php echo htmlspecialchars($setting['logo_web']); ?>
                                <?php endif; ?>
                            </div>
                            <div class="mb-3">
                                <label for="favicon" class="form-label">Favicon</label>
                                <input type="file" class="form-control" id="favicon" name="favicon" >
                                <?php if (!empty($setting['favicon'])): ?>
                                    Current: <?php echo htmlspecialchars($setting['favicon']); ?>
                                <?php endif; ?>
                                
                            </div>
                            <button type="submit" class="btn btn-primary">Save Settings</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include_once '../includes/footer.php'; ?>



<!-- Backend Bundle JavaScript -->
<script src="../assets/js/libs.min.js"></script>
<!-- widgetchart JavaScript -->
<script src="../assets/js/charts/widgetcharts.js"></script>
<!-- fslightbox JavaScript -->
<script src="../assets/js/fslightbox.js"></script>
<!-- app JavaScript -->
<script src="../assets/js/app.js"></script>
<!-- apexchart JavaScript -->
<script src="../assets/js/charts/apexcharts.js"></script>

</body>
</html>

