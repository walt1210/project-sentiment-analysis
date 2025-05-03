<?php
  require_once __DIR__ . '/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sentimo — Customer Login</title>
  <link rel="stylesheet" href="./assets/styles.css?v=2">
</head>
<body>
  <nav class="navbar">
    <div class="logo">
        <a href="login.php" class="logo">
            <img src="./assets/logo-icon.png" alt="Sentimo icon">
            <img src="./assets/logo-text.png" alt="Sentimo text">
        </a>
    </div>
    <ul class="nav-links">
      <li><a href="about.php">About</a></li>
      <li><a href="creators.php">Creators</a></li>
    </ul>
  </nav>

  <main class="login-page">
    <div class="graphic">
      <img src="./assets/logo-full.png" alt="Sentimo graphic">
    </div>

    <div class="login-card">
      <h2>Login</h2>
      <p class="subhead">
        Login to your account
        <span class="admin">Admin? <a href="./views/admin/admin_login.php">Login Here</a></span>
      </p>
      <form action="./controllers/LoginController.php" method="post">
        <input type="email" name="email" id="email" placeholder="Email" required>
        <input type="password" name="password" id="password" placeholder="Password" minlength="8" required>
        <button type="submit">LOGIN</button>
      </form>
      <div class="footer-links">
        <a href="forgot_password.php">Forgot Password</a>
        <span>New to Sentimo? <a href="register.php">Sign-up</a></span>
      </div>
    </div>
  </main>
</body>
<script>
  window.addEventListener('pageshow', function (event) {
    if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
      location.reload(); // Reloads page and re-triggers PHP
    }
  });
</script>
</html>
