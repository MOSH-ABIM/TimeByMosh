<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$total = 0;
foreach ($_SESSION['cart'] as $product_id => $quantity) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();
    $subtotal = $product['price'] * $quantity;
    $total += $subtotal;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $required_fields = ['fullname', 'email', 'address', 'city', 'zip', 'card_number', 'exp_date', 'cvv'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $error = "Please fill in all shipping and payment fields.";
            break;
        }
    }

    if (!isset($error)) {
        $user_id = $_SESSION['user_id'];

        $pdo->beginTransaction();
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount, created_at) VALUES (?, 0, NOW())");
        $stmt->execute([$user_id]);
        $order_id = $pdo->lastInsertId();

        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$product_id]);
            $product = $stmt->fetch();
            $subtotal = $product['price'] * $quantity;

            $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
            $stmt->execute([$order_id, $product_id, $quantity]);
        }

        $stmt = $pdo->prepare("UPDATE orders SET total_amount = ? WHERE id = ?");
        $stmt->execute([$total, $order_id]);
        $pdo->commit();

        unset($_SESSION['cart']);
        mail($_POST['email'], 'Order Confirmation', "Thanks for your order of $$total!");
        header("Location: order-success.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout - Time By Mosh</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div id="loader"></div>

<div class="form-wrapper">
  <div class="form-card">
    <h2>Review & Confirm Order</h2>
    <p class="checkout-summary">Your total is: <strong>$<?= number_format($total, 2) ?></strong></p>

    <?php if (!empty($error)): ?>
      <p class="form-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
      <h3>Shipping Information</h3>
      <input type="text" name="fullname" placeholder="Full Name" required>
      <input type="email" name="email" placeholder="Email Address" required>
      <input type="text" name="address" placeholder="Street Address" required>
      <input type="text" name="city" placeholder="City" required>
      <input type="text" name="zip" placeholder="ZIP Code" required>

      <h3>Payment Details</h3>
      <input type="text" name="card_number" placeholder="Card Number" required>
      <input type="text" name="exp_date" placeholder="MM/YY" required>
      <input type="text" name="cvv" placeholder="CVV" required>

      <button type="submit" class="checkout-button">✅ Place Order</button>
      <p class="form-note">Your information is secure. This is a demo checkout.</p>
    </form>

    <a href="cart.php" class="go-back">← Back to Cart</a>
  </div>
</div>

<script>
window.addEventListener('load', function() {
    document.getElementById('loader').style.display = 'none';
});
</script>

</body>
</html>
