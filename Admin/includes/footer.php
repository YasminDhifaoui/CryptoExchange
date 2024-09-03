<?php
require_once('../config/config.php');

// Fetch settings
try {
    $stmt = $pdo->prepare("SELECT footer_text, time_zone, latitude FROM setting");
    $stmt->execute();
    $setting = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error fetching settings: " . $e->getMessage();
}

// Set the default timezone
date_default_timezone_set($setting['time_zone'] ?? 'UTC');

// Get the current date and time
$currentDateTime = date('Y-m-d H:i:s');
?>


<footer class="footer">
    <div class="footer-body">
        <ul class="left-panel list-inline mb-0 p-0">
            <li class="list-inline-item"><?php if (isset($setting['footer_text'])): ?>
                <?php echo htmlspecialchars($setting['footer_text']); ?>
            <?php endif; ?></li>
        </ul>
        <div class="right-panel">
            
            <span class="text-gray">
                <?php echo htmlspecialchars($currentDateTime); ?> (<?php echo htmlspecialchars($setting['time_zone']); ?>)
            </span>
            <br>
            <br>
            
        </div>
    </div>
</footer>
