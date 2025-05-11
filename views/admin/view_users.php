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
  <link rel="stylesheet" href="../../assets/styles.css?v=2">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="dashboard.php">
          <img src="../../assets/logo-icon.png" alt="Sentimo icon" height="50">
          <img src="../../assets/logo-text.png" alt="Sentimo text" height="50">
        </a>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a class="nav-link" href="add_products.php">Add Product</a></li>
          <li class="nav-item"><a class="nav-link" href="add_categories.php">Add Categories</a></li>
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
            <th>Role</th>
            <th>Last Login</th>
          </tr>
        </thead>
        <tbody>
          <!-- Sample Users -->
          <!-- <tr>
            <td>001</td>
            <td>Taylor Swift</td>
            <td>taylor.swift@gmail.com</td>
            <td>Super Admin</td> 
            <td>2025-04-17 12:34:56</td>
          </tr>
          <tr>
            <td>002</td>
            <td>Kali Uchis</td>
            <td>kali.uchis@gmail.com</td>
            <td>Administrator</td>
            <td>2025-04-16 10:20:30</td>
          </tr>
          <tr>
            <td>003</td>
            <td>Sabrina Carpenter</td>
            <td>sabrina.carpenter@gmail.com</td>
            <td>User</td>
            <td>2025-04-15 15:45:10</td>
          </tr> -->
        </tbody>
      </table>
    </div>

  </main>

  <footer class="site-footer">
    <div class="logo-small">
      <img src="../../assets/logo-icon.png" alt="">
      <img src="../../assets/logo-text.png" alt="">
    </div>
    <ul class="footer-links">
      <li><a href="../../about.php">About</a></li>
      <li><a href="../../creators.php">Creators</a></li>
    </ul>
  </footer>

  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
  <script>
    window.addEventListener('pageshow', function (event) {
    if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
      location.reload(); // Reloads page and re-triggers PHP
    }
  });
    $(document).ready(function() {
      // Initialize DataTable
      // $('#usersTable').DataTable({
      //   paging: true,
      //   searching: true,
      //   ordering: true,
      //   lengthChange: true,
      //   pageLength: 10 
      // });


      let table = $('#usersTable').DataTable({
        processing: true,
        serverSide: false,
        ajax:  {
          url: './../../controllers/UserController.php', 
          type: 'GET',
          dataType: 'json',
          dataSrc: function(response) {
            if(response.data.length > 0){
              return response.data; 
            } else {
              alert('No accounts found.');
              return []; 
            }
         }
        },
        columns: [
          { data: 'id' },
          {
              data: null,
              render: function(data, type, row) {
                  return row.first_name + ' ' + row.last_name;
              }
          },
          { data: 'email' },
          { data: 'role_name', render: function(data) {
            return data.replace(/\b\w/g, char => char.toUpperCase()); 
            } 
          },
          { data: 'latest_login'}
        ],
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
