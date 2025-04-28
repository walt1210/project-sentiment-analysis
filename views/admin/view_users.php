<?php
  require_once __DIR__ . '/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sentimo — View Users</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
  <link rel="stylesheet" href="/project-sentiment-analysis/assets/styles.css?v=2">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="dashboard.php">
          <img src="/project-sentiment-analysis/assets/logo-icon.png" alt="Sentimo icon" height="50">
          <img src="/project-sentiment-analysis/assets/logo-text.png" alt="Sentimo text" height="50">
        </a>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a class="nav-link" href="add_products.php">Add Product</a></li>
          <li class="nav-item"><a class="nav-link" href="view_users.php">View Users</a></li>
          <li class="nav-item"><a class="nav-link" href="../../logoutController.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
        </ul>
      </div>
    </nav>

  <main class="manageUsers-page">

    <!-- 1) Full‑bleed hero GIF -->
    <section class="hero">
      <img src="/project-sentiment-analysis/assets/manage-users.gif" alt="Sentimo Manage Users overview">
    </section>

    <!-- 2) Page heading -->
    <h2 class="mt-5">View Users</h2>

    <!-- 3) Responsive users table -->
    <div class="table-wrapper">
      <table id="usersTable" class="table table-striped table-bordered" style="width:100%">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role ID</th>
            <th>Last Login</th>
          </tr>
        </thead>
        <tbody>
          <!-- Sample Users -->
          <tr>
            <td>001</td>
            <td>Taylor Swift</td>
            <td>taylor.swift@gmail.com</td>
            <td>1</td> <!-- Role ID: 2 (User) -->
            <td>2025-04-17 12:34:56</td>
          </tr>
          <tr>
            <td>002</td>
            <td>Kali Uchis</td>
            <td>kali.uchis@gmail.com</td>
            <td>2</td> <!-- Role ID: 2 (User) -->
            <td>2025-04-16 10:20:30</td>
          </tr>
          <tr>
            <td>003</td>
            <td>Sabrina Carpenter</td>
            <td>sabrina.carpenter@gmail.com</td>
            <td>1</td> <!-- Role ID: 1 (Admin) -->
            <td>2025-04-15 15:45:10</td>
          </tr>
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

  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
  <script>
    $(document).ready(function() {
      // Initialize DataTable
      $('#usersTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        lengthChange: true,
        pageLength: 10 
      });

      // Handle Make Admin Action
      $('.make-admin').on('click', function() {
        const userId = $(this).data('id');
        if (confirm('Are you sure you want to make this user an admin?')) {
          alert('User with ID ' + userId + ' is now an admin (sample action).');
          // Backend integration: Replace this alert with an AJAX call to update the user role
        }
      });

      // Handle Deactivate Action
      $('.deactivate').on('click', function() {
        const userId = $(this).data('id');
        if (confirm('Are you sure you want to deactivate this user?')) {
          alert('User with ID ' + userId + ' is now deactivated (sample action).');
          // Backend integration: Replace this alert with an AJAX call to deactivate the user
        }
      });
    });
  </script>
</body>
</html>
