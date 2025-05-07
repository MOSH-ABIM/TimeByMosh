<?php
require 'config.php';

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Time By Mosh - Home</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
    html {
      scroll-behavior: smooth;
    }
    </style>
</head>
<body>

<div id="loader"></div>

<nav>
    <a href="index.php">Home</a>
    <a href="cart.php">View Cart</a>
    <a href="admin.php">Admin Panel</a>
    <a href="logout.php">Logout</a>
</nav>

<section class="hero-banner">
    <h1>Welcome to Time by Mosh</h1>
    <p>"Time is yours, Wear it well"</p>
    <p>Shop the best products with the best deals!</p>
    <a href="#products" class="shop-now-button">Shop Now</a>
</section>

<section id="products">
    <h2>Featured Products</h2>

    <div class="products-grid">
        <?php foreach ($products as $product): ?>
            <div class="product">
                <?php if ($product['image_url']): ?>
                    <img src="images/<?= htmlspecialchars($product['image_url']) ?>" width="200" alt="Product Image"><br>
                <?php endif; ?>
                <h3><?= htmlspecialchars($product['name']) ?></h3>
                <p><?= htmlspecialchars($product['description']) ?></p>
                <p><strong>$<?= number_format($product['price'], 2) ?></strong></p>
                <form method="POST" action="cart.php">
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                    <input type="number" name="quantity" value="1" min="1" required>
                    <button type="submit">Add to Cart</button>
                </form>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<footer>
    <p>© <?= date('Y') ?> TimeByMosh. All Rights Reserved.</p>
</footer>

<script>
window.addEventListener('load', function() {
    document.getElementById('loader').style.display = 'none';
});
</script>

</body>
</html>
