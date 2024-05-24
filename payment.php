<?php
session_start();

// Get payment data from POST
$name = $_POST['name'];
$paymentMethod = $_POST['payment_method'];
$total = $_POST['total'];

// Simulate payment processing (replace with actual payment gateway integration)
$paymentStatus = "success"; // or "failed" based on payment processing logic

// Display payment confirmation
?>
<!DOCTYPE html>
<html>
<head>
  <title>Konfirmasi Pembayaran</title>
  <link rel="stylesheet" type="text/css" href="paymentstyle.css">
</head>
<body>
  <div class="container">
    <h1>Konfirmasi Pembayaran</h1>

    <?php if (isset($_SESSION['name'])): ?>
      <p>Selamat datang, <?php echo htmlspecialchars($_SESSION['name']); ?>!</p>
    <?php endif; ?>

    <p>Terima kasih atas pesanan Anda!</p>

    <p><b>Rincian Pembayaran:</b></p>
    <ul>
      <li>Nama: <?php echo htmlspecialchars($name); ?></li>
      <li>Metode Pembayaran: <?php echo htmlspecialchars($paymentMethod); ?></li>
      <li>Total: Rp<?php echo number_format($total, 0, ',', '.'); ?></li>
    </ul>

    <?php if ($paymentStatus == "success"): ?>
      <p>Pembayaran Anda telah berhasil diproses.</p>
    <?php else: ?>
      <p>Maaf, terjadi kesalahan saat memproses pembayaran Anda. Silakan coba lagi nanti atau hubungi kami untuk bantuan.</p>
    <?php endif; ?>

    <p><a href="index.php">Kembali ke Toko</a></p>
  </div>
</body>
</html>
