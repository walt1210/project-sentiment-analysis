<?php
  require_once __DIR__ . '/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sentimo — Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="/project-sentiment-analysis/assets/styles.css?v=2">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="superAdmin_dashboard.php">
          <img src="/project-sentiment-analysis/assets/logo-icon.png" alt="Sentimo icon" height="50">
          <img src="/project-sentiment-analysis/assets/logo-text.png" alt="Sentimo text" height="50">
        </a>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link">
              <img src="/project-sentiment-analysis/assets/logo-icon.png" alt="Super Admin Icon" height="20" style="margin-right: 5px;">
              <strong>Super Admin</strong>
            </a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a class="nav-link" href="superAdmin_add_products.php">Add Product</a></li>
          <li class="nav-item"><a class="nav-link" href="manage_users.php">Manage Users</a></li>
          <li class="nav-item"><a class="nav-link" href="../../logoutController.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
        </ul>
      </div>
    </nav>

    <!-- 1) hero GIF -->
    <section class="hero">
      <img src="/project-sentiment-analysis/assets/admin-dashboard-here.gif" alt="Sentimo Admin Dashboard overview">
    </section>

  <main class="dashboard-page">

    <!-- 2) sentiment -->
    <h2>Sentiment Report</h2>
    <section class="sentiment-reports">
        <div class="sentiment-card">
        <h3>125</h3>
        <p>Total Reviews</p>
    </div>
    <div class="sentiment-card">
        <h3>60%</h3>
        <p>Positive</p>
    </div>
    <div class="sentiment-card">
        <h3>25%</h3>
        <p>Negative</p>
    </div>
    <div class="sentiment-card">
        <h3>15%</h3>
        <p>Neutral</p>
    </div>
    </section>

  
    <!-- 3) Products Table -->
    <h2>Product List</h2>
    <section class="product-table">
      <table id="productTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
          <tr>
            <th>ID</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Example rows, replace with dynamic PHP data -->
          <tr>
            <td>1</td>
            <td>Superstar II Shoes</td>
            <td>Fashion</td>
            <td>₱5,500</td>
            <td>
              <button class="btn btn-primary btn-sm">Edit</button>
              <button class="btn btn-danger btn-sm">Delete</button>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>Smartphone X</td>
            <td>Electronics</td>
            <td>₱25,000</td>
            <td>
              <button class="btn btn-primary btn-sm">Edit</button>
              <button class="btn btn-danger btn-sm">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </section>

  </main>

  <footer class="site-footer" style="background-color: #343a40; color: #f8f9fa; padding: 20px; text-align: center;">
    <div class="logo-small">
      <img src="/project-sentiment-analysis/assets/logo-icon.png" alt="">
      <img src="/project-sentiment-analysis/assets/logo-text.png" alt="">
    </div>
    <ul class="footer-links">
      <li><a href="/project-sentiment-analysis/about.php" style="color: #f8f9fa; text-decoration: none;">About</a></li>
      <li><a href="/project-sentiment-analysis/creators.php" style="color: #f8f9fa; text-decoration: none;">Creators</a></li>
    </ul>
  </footer>

  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>

  <script>
    $(document).ready(function() {
      $('#productTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        lengthChange: true,
        pageLength: 10
      });
    });
  </script>
</body>
</html>
