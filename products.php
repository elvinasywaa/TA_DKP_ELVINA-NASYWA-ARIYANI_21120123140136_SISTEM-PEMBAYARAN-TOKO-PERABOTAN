<?php
session_start();

$products = array(
  array("id" => 1, "name" => "Piring kaca", "price" => 12000),
  array("id" => 2, "name" => "Piring plastik", "price" => 5000),
  array("id" => 3, "name" => "Mangkok kaca", "price" => 10000),
  array("id" => 4, "name" => "Mangkok plastik", "price" => 4000),
  array("id" => 5, "name" => "1 set alat makan", "price" => 35000),
  array("id" => 6, "name" => "Sendok makan", "price" => 5000),
  array("id" => 7, "name" => "Garpu makan", "price" => 5000),
  array("id" => 8, "name" => "Gelas kaca", "price" => 12000),
  array("id" => 9, "name" => "Gelas plastik", "price" => 4000),
  array("id" => 10, "name" => "Tutup gelas", "price" => 5000),
  array("id" => 11, "name" => "Sapu lidi", "price" => 8000),
  array("id" => 12, "name" => "Sapu ijuk", "price" => 20000),
  array("id" => 13, "name" => "Pel lantai", "price" => 25000),
  array("id" => 14, "name" => "Ember", "price" => 27000),
  array("id" => 15, "name" => "Tempat sampah", "price" => 32000),
  array("id" => 16, "name" => "Payung", "price" => 40000),
  array("id" => 17, "name" => "Jas hujan", "price" => 70000),
  array("id" => 18, "name" => "Jam dinding", "price" => 30000),
  array("id" => 19, "name" => "Jam weker", "price" => 38000),
  array("id" => 20, "name" => "Hanger (5pcs)", "price" => 15000),
  array("id" => 21, "name" => "Jepit jemuran", "price" => 9000),
);

if (isset($_POST['add'])) {
  $productId = $_POST['product_id'];
  $quantity = $_POST['quantity'];

  if (!empty($productId) && !empty($quantity)) {
    if (!isset($_SESSION['cart'])) {
      $_SESSION['cart'] = array();
    }

    if (array_key_exists($productId, $_SESSION['cart'])) {
      $_SESSION['cart'][$productId]['quantity'] += $quantity;
    } else {
      $_SESSION['cart'][$productId] = array(
        'id' => $productId,
        'name' => $products[$productId - 1]['name'],
        'price' => $products[$productId - 1]['price'],
        'quantity' => $quantity
      );
    }
  }
}

if (isset($_POST['less'])) {
  $productId = $_POST['product_id'];
  $quantity = $_POST['quantity'];

  if (!empty($productId) && !empty($quantity)) {
    if (isset($_SESSION['cart']) && array_key_exists($productId, $_SESSION['cart'])) {
      $_SESSION['cart'][$productId]['quantity'] -= $quantity;

      if ($_SESSION['cart'][$productId]['quantity'] <= 0) {
        unset($_SESSION['cart'][$productId]);
      }
    }
  }
}

$cartExists = isset($_SESSION['cart']) && count($_SESSION['cart']) > 0;
?>

<!DOCTYPE html>
<html>
<head>
  <title>Cozy Home</title>
  <link rel="stylesheet" href="cartstyle.css">
</head>
<body>
  <div class="container">
    <h1>Cozy Home</h1>
    <p>Come Home to Feeling of Cozy Home</p>
    <?php if (isset($_SESSION['name'])): ?>

    <?php endif; ?>

    <!-- Product List Section -->
    <div class="product-section">
      <table>
        <tr>
          <th>Nama Barang</th>
          <th>Harga</th>
          <th>Jumlah</th>
          <th>Keranjang Belanja</th>
        </tr>
        <?php foreach ($products as $product): ?>
          <tr>
            <td><?php echo htmlspecialchars($product['name']); ?></td>
            <td>Rp<?php echo number_format($product['price'], 0, ',', '.'); ?></td>
            <td>
              <form method="post" action="">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <input type="number" name="quantity" min="1" value="1">
            </td>
            <td>
                <input type="submit" name="add" value="+">
                <input type="submit" name="less" value="-">
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </table>
    </div>

    <!-- Cart Section -->
    <div class="cart-section">
      <?php if ($cartExists): ?>
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

        <form method="post" action="payment.php">
          <label for="payment_method">Metode Pembayaran:</label>
          <select id="payment_method" name="payment_method" required>
            <option value="Cash">Cash</option>
          </select><br>

          <input type="hidden" name="total" value="<?php echo $total; ?>">

          <button type="submit">Bayar Sekarang</button>
        </form>
      <?php else: ?>
        <p>Keranjang Anda kosong.</p>
      <?php endif; ?>
    </div>

    <!-- Back Button Section -->
    <div class="back-button">
      <?php
      echo '<button onclick="window.history.back()">Kembali</button>';
      ?>
    </div>
  </div>
</body>
</html>
