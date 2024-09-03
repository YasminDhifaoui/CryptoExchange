<?php 
require_once('../../Admin/config/config.php');

$stmt = $pdo->query("SELECT * FROM setting");
$setting = $stmt->fetch(); 
?>

<title>
    <?php echo htmlspecialchars($setting['title']); ?>
</title>
<link rel="shortcut icon" href="<?php echo htmlspecialchars($setting['favicon']); ?>" />
