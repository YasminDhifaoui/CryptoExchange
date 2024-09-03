<?php
require '../config/config.php';

session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['admin_username'];

$sql = 'SELECT * FROM users';
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once '../includes/title.php'; ?>
    <link rel="stylesheet" href="../assets/css/libs.min.css">
    <link rel="stylesheet" href="../assets/css/coinex.css?v=1.0.0">
</head>
<style>
/* Styled Table */
.styled-table {
    border-collapse: collapse;
    margin: 25px 0;
    font-size: 0.9em;
    font-family: 'Arial', sans-serif;
    width: 100%;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}

.styled-table thead tr {
    background-color: #ffa500;
    color: #ffffff;
    text-align: left;
}

.styled-table th, .styled-table td {
    padding: 12px 15px;
}

.styled-table tbody tr {
    background-color: #000000;
    color: #ffffff;
    border-bottom: 1px solid #ffffff;
}

.styled-table tbody tr:last-of-type {
    border-bottom: 2px solid #ffa500;
}

/* Toggle Switch */
.switch-custom {
    position: relative;
    display: inline-block;
    width: 45px;
    height: 25px;
}

.switch-custom input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider-custom {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.4s;
    border-radius: 34px;
}

.slider-custom:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 4px;
    bottom: 2px;
    background-color: white;
    transition: 0.4s;
    border-radius: 50%;
}

input:checked + .slider-custom {
    background-color: #2196F3;
}

input:checked + .slider-custom:before {
    transform: translateX(20px);
}
</style>

<body class="sb-nav-fixed">
<?php include_once '../includes/nav.php'; ?>
<?php include_once '../includes/sidebar.php'; ?>

<main class="main-content">
    <div class="container-fluid content-inner pb-0">
        <img src="../uploads/Users.png" width="90px"><br><br><br><br>
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>LastName</th>
                    <th>Email</th>
                    <th>Created_at</th>
                    <th>Is_active</th>
                    <th>Actions</th>
                    <th>Block/unblock</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php if (count($users) > 0): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['lastName']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                            <td><?php echo htmlspecialchars($user['is_active']); ?></td>
                            <td>
                                <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a>
                                <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            </td>
                            <td>
                            <label class="switch-custom">
                                    <input type="checkbox" class="toggle-block" data-user-id="<?php echo $user['id']; ?>" data-user-email="<?php echo htmlspecialchars($user['email']); ?>" 
                                        <?php 
                                        $stmt = $pdo->prepare('SELECT * FROM blocklist WHERE ip_mail = :email');
                                        $stmt->execute(['email' => $user['email']]);
                                        $isBlocked = $stmt->fetch();
                                        echo $isBlocked ? 'checked' : ''; 
                                        ?>>
                                    <span class="slider-custom"></span>
                            </label>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include_once '../includes/footer.php'; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggles = document.querySelectorAll('.toggle-block');

    toggles.forEach(toggle => {
        toggle.addEventListener('change', function() {
            const userId = this.getAttribute('data-user-id');
            const userEmail = this.getAttribute('data-user-email');
            const isBlocked = this.checked ? 1 : 0;

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'block_user.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    console.log('User block status updated successfully');
                } else {
                    console.error('Failed to update user block status');
                }
            };
            xhr.send('user_id=' + userId + '&email=' + userEmail + '&is_blocked=' + isBlocked);
        });
    });
});
</script>

<script src="../assets/js/libs.min.js"></script>
<script src="../assets/js/app.js"></script>
</body>
</html>
