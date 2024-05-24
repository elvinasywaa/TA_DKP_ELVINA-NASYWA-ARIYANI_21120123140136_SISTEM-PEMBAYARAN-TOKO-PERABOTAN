<?php
session_start();

// Check if cart exists
if (!isset($_SESSION['cart'])) {
  echo "Keranjang Anda kosong.";
  exit;
}

// Display cart contents
?>
<!DOCTYPE html>
<html>
<head>
  <title>Keranjang Belanja</title>
  <link rel="stylesheet" type="text/css" href="cartstyle.css">
</head>
<body>
  <div class="container">
    <h1>Keranjang Belanja</h1>

    <?php if (isset($_SESSION['name'])): ?>
      <p>Selamat datang, <?php echo htmlspecialchars($_SESSION['name']); ?>!</p>
    <?php endif; ?>

    <table>
      <tr>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Total</th>
      </tr>
      <?php
      $total = 0;
      foreach ($_SESSION['cart'] as $item): ?>
        <tr>
          <td><?php echo htmlspecialchars($item['name']); ?></td>
          <td>Rp<?php echo number_format($item['price'], 0, ',', '.'); ?></td>
          <td><?php echo $item['quantity']; ?></td>
          <td>Rp<?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?></td>
        </tr>
        <?php
        $total += $item['price'] * $item['quantity'];
      endforeach; ?>
      <tr>
        <td colspan="3">Total:</td>
        <td>Rp<?php echo number_format($total, 0, ',', '.'); ?></td>
      </tr>
    </table>

    <h2>Pembayaran</h2>

    <form method="post" action="payment.php">
      <label for="name">Nama Lengkap:</label>
      <input type="text" id="name" name="name" required><br>

      <label for="payment_method">Metode Pembayaran:</label>
      <select id="payment_method" name="payment_method" required>
        <option value="transfer_bank">Transfer Bank</option>
        <option value="virtual_account">Virtual Account</option>
      </select><br>

      <input type="hidden" name="total" value="<?php echo $total; ?>">

      <button type="submit">Bayar Sekarang</button>
    </form>

    <p><a href="index.php">Lanjutkan Belanja</a></p>
  </div>
</body>
</html>
