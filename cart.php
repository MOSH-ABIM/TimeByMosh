<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $_SESSION['cart'][$product_id] = ($_SESSION['cart'][$product_id] ?? 0) + $quantity;
}

$cart_items = [];
$total = 0;

if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_keys($_SESSION['cart']));
    $stmt = $pdo->query("SELECT * FROM products WHERE id IN ($ids)");
    $cart_items = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shopping Cart - SwiftCart</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div id="loader"></div>

<h2>Your Cart</h2>
<a href="index.php">Continue Shopping</a> | <a href="checkout.php">Checkout</a><br><br>

<?php if ($cart_items): ?>
    <ul>
    <?php foreach ($cart_items as $item): ?>
        <?php $subtotal = $item['price'] * $_SESSION['cart'][$item['id']]; ?>
        <li>
            <?= htmlspecialchars($item['name']) ?> - $<?= number_format($item['price'], 2) ?> 
            x <?= $_SESSION['cart'][$item['id']] ?> = $<?= number_format($subtotal, 2) ?>
        </li>
        <?php $total += $subtotal; ?>
    <?php endforeach; ?>
    </ul>

    <h3>Total: $<?= number_format($total, 2) ?></h3>
<?php else: ?>
    <p>Your cart is empty!</p>
<?php endif; ?>

<script>
window.addEventListener('load', function() {
    document.getElementById('loader').style.display = 'none';
});
</script>

</body>
</html>
