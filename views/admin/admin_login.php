<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sentimo — Admin Login</title>
  <link rel="stylesheet" href="/project-sentiment-analysis/assets/styles.css?v=2">
</head>
<body>
  <nav class="navbar">
    <div class="logo">
        <a href="/project-sentiment-analysis/index.php" class="logo">
            <img src="/project-sentiment-analysis/assets/logo-icon.png" alt="Sentimo icon">
            <img src="/project-sentiment-analysis/assets/logo-text.png" alt="Sentimo text">
        </a>
    </div>
    <ul class="nav-links">
      <li><a href="/project-sentiment-analysis/about.php">About</a></li>
      <li><a href="/project-sentiment-analysis/creators.php">Creators</a></li>
    </ul>
  </nav>

  <main class="adminLogin-page">
    <div class="login-card">
        <div class="graphic">
            <img src="/project-sentiment-analysis/assets/logo-full.png" alt="Sentimo graphic">
        </div>
      <h2>Admin Login</h2>
      <p class="subhead">
        Login to your account
      </p>
      <form action="authenticate.php" method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">LOGIN</button>
      </form>
      <div class="footer-links">
        <span>Not an Admin? <a href="/project-sentiment-analysis/login.php">Login here</a></span>
      </div>
    </div>
  </main>
</body>
</html>
