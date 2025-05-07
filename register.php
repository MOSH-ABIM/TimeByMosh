<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $password]);
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Time By Mosh</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div id="loader"></div>

<div class="form-wrapper">
  <div class="form-card">
    <h1 class="brand">Time By Mosh</h1>
    <h2>Create an Account</h2>

    <form method="POST">
      <label for="name">Name</label>
      <input type="text" name="name" id="name" placeholder="Enter your name" required>

      <label for="email">Email</label>
      <input type="email" name="email" id="email" placeholder="Enter your email" required>

      <label for="password">Password</label>
      <input type="password" name="password" id="password" placeholder="Enter a secure password" required>

      <button type="submit">Register</button>
      <p class="form-note">Already have an account? <a href="login.php">Log in here</a>.</p>
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
