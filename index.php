<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    if (!empty($name)) {
        $_SESSION['name'] = $name;
        header('Location: products.php');
        exit();
    } else {
        $error = "Name is required!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Cozy Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Cozy Home</h1>
    <p>Come Home to Feeling of Cozy Home</p>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="name">Nama Pelanggan:</label>
        <input type="text" id="name" name="name" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>