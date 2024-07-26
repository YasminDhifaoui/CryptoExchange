<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Deconnect</title>
    <script type="text/javascript">
        alert("You have been logged out");
        window.location.href = "sign-in.php";
    </script>
</head>
<body>
</body>
</html>
