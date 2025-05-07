<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $stmt = $pdo->prepare("INSERT INTO products (name, description, price) VALUES (?, ?, ?)");
    $stmt->execute([$name, $description, $price]);
    header("Location: admin.php");
    exit;
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: admin.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - SwiftCart</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Admin Panel - Manage Products</h2>
<a href="index.php">Back to Shop</a> | <a href="logout.php">Logout</a><br><br>

<h3>Add New Product</h3>
<form method="POST">
    <input type="text" name="name" placeholder="Product Name" required><br>
    <textarea name="description" placeholder="Product Description" required></textarea><br>
    <input type="number" name="price" placeholder="Price" step="0.01" required><br>
    <button type="submit" name="add_product">Add Product</button>
</form>

<hr>

<h3>Existing Products</h3>
<?php foreach ($products as $product): ?>
    <div class="product">
        <h4><?= htmlspecialchars($product['name']) ?> - $<?= number_format($product['price'], 2) ?></h4>
        <p><?= htmlspecialchars($product['description']) ?></p>
        <a href="admin.php?delete=<?= $product['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
    </div>
<?php endforeach; ?>

</body>
</html>
