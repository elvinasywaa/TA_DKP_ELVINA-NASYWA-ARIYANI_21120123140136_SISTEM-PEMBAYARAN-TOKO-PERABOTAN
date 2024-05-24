<?php
session_start();

if (!isset($_SESSION['name'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="welcomestyle.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h1>
        <p>Selamat berbelanja!</p>
        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>
