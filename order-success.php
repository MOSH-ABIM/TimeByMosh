<?php require 'config.php'; ?>

<!DOCTYPE html>
<html>
<head>
  <title>Order Confirmed - SwiftCart</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div id="loader"></div>

<div class="form-wrapper">
  <div class="form-card">
    <h2>🎉 Thank You for Your Order!</h2>
    <p class="checkout-summary">
      Your order has been successfully placed.<br>
      A confirmation email has been sent to your inbox.
    </p>

    <a href="index.php" class="checkout-button" style="text-align:center; display:block; text-decoration:none;">
      🏠 Back to Home
    </a>
  </div>
</div>

<script>
window.addEventListener('load', function() {
  document.getElementById('loader').style.display = 'none';
});
</script>

</body>
</html>
