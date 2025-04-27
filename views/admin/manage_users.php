<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sentimo — Manage Users</title>
  <link rel="stylesheet"
        href="/project-sentiment-analysis/assets/styles.css?v=2">
</head>
<body>
  <nav class="navbar">
    <div class="logo">
        <a href="dashboard.php" class="logo">
            <img src="/project-sentiment-analysis/assets/logo-icon.png" alt="Sentimo icon">
            <img src="/project-sentiment-analysis/assets/logo-text.png" alt="Sentimo text">
        </a>
    </div>
    <ul class="nav-links">
        <li><a href="add_products.php">Add Product</a></li>
        <li><a href="manage_users.php">Manage Users</a></li>
        <li><a href="/project-sentiment-analysis/index.php">Logout</a></li>
    </ul>
  </nav>

  <main class="manageUsers-page">

    <!-- 1) Full‑bleed hero GIF -->
    <section class="hero">
      <img src="/project-sentiment-analysis/assets/manage-users.gif"
           alt="Sentimo Manage Users overview">
    </section>

    <!-- 2) Page heading -->
    <h2>Manage Users</h2>

    <!-- 3) Responsive users table -->
    <div class="table-wrapper">
      <table class="reviews-table users-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Last Login</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- loop users here, sample only -->
          <tr>
            <td>001</td>
            <td>Taylor Swift</td>
            <td>taylor.swift@gmail.com</td>
            <td>2025-04-17 12:34:56</td>
            <td>
              <button class="action-btn make-admin">Make Admin</button>
              <button class="action-btn deactivate">Deactivate</button>
            </td>
          </tr>
          <!-- …etc… -->
        </tbody>
      </table>
    </div>

  </main>

  <footer class="site-footer">
    <div class="logo-small">
      <img src="/project-sentiment-analysis/assets/logo-icon.png" alt="">
      <img src="/project-sentiment-analysis/assets/logo-text.png" alt="">
    </div>
    <ul class="footer-links">
    <li><a href="/project-sentiment-analysis/about.php">About</a></li>
    <li><a href="/project-sentiment-analysis/creators.php">Creators</a></li>
    </ul>
  </footer>
</body>
</html>
