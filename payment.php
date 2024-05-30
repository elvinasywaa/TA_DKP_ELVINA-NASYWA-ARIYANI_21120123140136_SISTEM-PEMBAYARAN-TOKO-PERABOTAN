<?php
session_start();
$paymentMethod = $_POST['payment_method'];
$total = $_POST['total'];
$paymentStatus = "success";
$itemsInCart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$totalBelanja = 0;
foreach ($itemsInCart as $item) {
    $totalBelanja += $item['price'] * $item['quantity'];
}
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
      <p>Nama Pelanggan: <?php echo htmlspecialchars($_SESSION['name']); ?></p>
    <?php endif; ?>

    <p><b>Barang:</b></p>
    <ul>
      <?php foreach ($itemsInCart as $item): ?>
        <li><?php echo htmlspecialchars($item['name']); ?> - Jumlah: <?php echo $item['quantity']; ?> - Harga Satuan: Rp<?php echo number_format($item['price'], 0, ',', '.'); ?></li>
      <?php endforeach; ?>
    </ul>

    <p><b>Rincian Pembayaran:</b></p>
    <ul>
      <li>Metode Pembayaran: <?php echo htmlspecialchars($paymentMethod); ?></li>
      <li>Total: Rp<?php echo number_format($total, 0, ',', '.'); ?></li>
    </ul>
    <p>Terima kasih atas pesanan Anda!</p>
    <?php
    echo '<p><a href="index.php">Kembali ke Toko</a></p>';
    ?>
  </div>

  <?php
  unset($_SESSION['cart']);
  ?>
</body>
</html>