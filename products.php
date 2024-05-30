<?php
session_start();

class Product {
    public $id;
    public $name;
    public $price;

    public function __construct($id, $name, $price) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
    }
}

class ShoppingCart {
    public $products;

    public function __construct($products) {
        $this->products = $products;
    }

    public function addToCart($productId, $quantity) {
        if (!empty($productId) && !empty($quantity)) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();
            }

            if (array_key_exists($productId, $_SESSION['cart'])) {
                $_SESSION['cart'][$productId]['quantity'] += $quantity;
            } else {
                $product = $this->products[$productId - 1];
                $_SESSION['cart'][$productId] = array(
                    'id' => $productId,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity
                );
            }
        }
    }

    public function removeFromCart($productId, $quantity) {
        if (!empty($productId) && !empty($quantity)) {
            if (isset($_SESSION['cart']) && array_key_exists($productId, $_SESSION['cart'])) {
                $_SESSION['cart'][$productId]['quantity'] -= $quantity;

                if ($_SESSION['cart'][$productId]['quantity'] <= 0) {
                    unset($_SESSION['cart'][$productId]);
                }
            }
        }
    }
}

$products = array(
    new Product(1, "Piring kaca", 12000),
    new Product(2, "Piring plastik", 5000),
     new Product(3, "Mangkok kaca", 10000),
    new Product(4, "Mangkok plastik", 4000),
    new Product(5, "1 set alat makan", 35000),
    new Product(6, "Sendok makan", 5000),
    new Product(7, "Garpu makan", 5000),
    new Product(8, "Gelas kaca", 12000),
    new Product(9, "Gelas plastik", 4000),
    new Product(10, "Tutup gelas", 5000),
    new Product(11, "Sapu lidi", 8000),
    new Product(12, "Sapu ijuk", 20000),
    new Product(13, "Pel lantai", 25000),
    new Product(14, "Ember", 27000),
    new Product(15, "Tempat sampah", 32000),
    new Product(16, "Payung", 40000),
    new Product(17, "Jas hujan", 70000),
    new Product(18, "Jam dinding", 30000),
    new Product(19, "Jam weker", 38000),
    new Product(20, "Hanger (5pcs)", 15000),
    new Product(21, "Jepit jemuran", 9000)
);

$cart = new ShoppingCart($products);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $cart->addToCart($_POST['product_id'], $_POST['quantity']);
    } elseif (isset($_POST['less'])) {
        $cart->removeFromCart($_POST['product_id'], $_POST['quantity']);
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
            <td><?php echo htmlspecialchars($product->name); ?></td>
            <td>Rp<?php echo number_format($product->price, 0, ',', '.'); ?></td>
            <td>
            <form method="post" action="">
              <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product->id); ?>">
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
