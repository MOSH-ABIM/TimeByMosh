<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Time By Mosh</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div id="loader"></div>

<div class="form-wrapper">
  <div class="form-card">
    <h1 class="brand">Time By Mosh</h1>
    <h2>Welcome to Time By Mosh</h2>
    <p style="text-align:center;"><i>"A place where fashion and function are always in sync"</i></p>

    <?php if (!empty($error)): ?>
      <p class="form-error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="POST">
      <label for="email">Email</label>
      <input type="email" name="email" id="email" placeholder="Enter your email" required>

      <label for="password">Password</label>
      <input type="password" name="password" id="password" placeholder="Enter your password" required>

      <button type="submit">Login</button>
      <p class="form-note">Don’t have an account? <a href="register.php">Register here</a>.</p>
    </form>
  </div>
</div>

<script>
window.addEventListener('load', function() {
  document.getElementById('loader').style.display = 'none';
});
</script>

</body>
</html>
