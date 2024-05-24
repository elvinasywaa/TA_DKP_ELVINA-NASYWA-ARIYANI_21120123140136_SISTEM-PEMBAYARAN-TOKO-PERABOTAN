<?php
session_start();

// Define product data (replace with actual product data)
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
  array("id" => 20, "name" => "Hanger", "price" => 15000),
  array("id" => 21, "name" => "Jepit jemuran", "price" => 9000),
);

// Add item to cart (if add button is clicked)
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
        'name' => $products[$productId - 1]['name'], // array index starts from 0
        'price' => $products[$productId - 1]['price'],
        'quantity' => $quantity
      );
    }
  }
}

// Display product list
?>
<!DOCTYPE html>
<html>
<head>
  <title>Toko Perabotan</title>
  <link rel="stylesheet" type="text/css" href="productsstyle.css">
</head>
<body>
  <div class="container">
    <h1>Daftar Barang</h1>

    <?php if (isset($_SESSION['name'])): ?>
      <p>Selamat datang, <?php echo htmlspecialchars($_SESSION['name']); ?>!</p>
    <?php endif; ?>

    <table>
      <tr>
        <th>Nama Barang</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Tambah ke Keranjang</th>
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
              <input type="submit" name="add" value="Tambah">
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>

    <p><a href="cart.php">Lihat Keranjang</a></p>
  </div>
</body>
</html>
