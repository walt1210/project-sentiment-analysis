<?php
  require_once __DIR__ . '/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sentimo — Manage Users</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
  <link rel="stylesheet" href="../../assets/styles.css?v=2">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="dashboard.php">
            <img src="../../assets/logo-icon-light.png" alt="Sentimo icon" height="50">
            <img src="../../assets/logo-text-light.png" alt="Sentimo text" height="50">
        </a>
        <ul class="navbar-nav mx-auto">
            <li class="nav-item">
              <a class="nav-link">
                <img src="../../assets/super-admin-icon.png" alt="Super Admin Icon" height="40" style="margin-right: 5px;">
                <strong>Super Admin</strong>
              </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="dashboard.php">Manage Users</a></li>
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
    <h2 class="mt-5">Manage Users</h2>

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
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Sample Users -->
          <!-- <tr>
            <td>001</td>
            <td>Taylor Swift</td>
            <td>taylor.swift@gmail.com</td>
            <td>1</td>
            <td>2025-04-17 12:34:56</td>
            <td>
              <button class="btn btn-sm btn-primary make-admin" data-id="001">Make Admin</button>
              <button class="btn btn-sm btn-danger deactivate" data-id="001">Deactivate</button>
            </td>
          </tr>
          <tr>
            <td>002</td>
            <td>Kali Uchis</td>
            <td>kali.uchis@gmail.com</td>
            <td>2</td>
            <td>2025-04-16 10:20:30</td>
            <td>
              <button class="btn btn-sm btn-primary make-admin" data-id="002">Make Admin</button>
              <button class="btn btn-sm btn-danger deactivate" data-id="002">Deactivate</button>
            </td>
          </tr>
          <tr>
            <td>003</td>
            <td>Sabrina Carpenter</td>
            <td>sabrina.carpenter@gmail.com</td>
            <td>1</td>
            <td>2025-04-15 15:45:10</td>
            <td>
              <button class="btn btn-sm btn-primary make-admin" data-id="003" disabled>Make Admin</button>
              <button class="btn btn-sm btn-danger deactivate" data-id="003">Deactivate</button>
            </td>
          </tr> -->
        </tbody>
      </table>
    </div>

  </main>

  <footer class="site-footer" style="background-color: #343a40; color: #f8f9fa; padding: 20px; text-align: center;">
    <div class="logo-small" style="margin-left: 20px;">
      <img src="../../assets/logo-icon-light.png" alt="">
      <img src="../../assets/logo-text-light.png" alt="">
    </div>
    <ul class="footer-links">
      <li><a href="../../about.php" style="color: #f8f9fa; text-decoration: none;">About</a></li>
      <li><a href="../../creators.php" style="color: #f8f9fa; text-decoration: none;">Creators</a></li>
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


      let table = $('#usersTable').DataTable({
        processing: true,
        serverSide: false,
        ajax:  {
          url: './../../controllers/UserController.php', // Adjust the path to your API
          type: 'GET',
          dataType: 'json',
          dataSrc: function(response) {
            if(response.data.length > 0){
              return response.data; // Return the data array from the response
            } else {
              alert('No accounts found.');
              return []; // Return an empty array if no reviews found
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
            return data.replace(/\b\w/g, char => char.toUpperCase()); // Capitalize first letter of each word
            } 
          },
          { data: 'latest_login'},
          { data: null, render: function(data, type, row) {
              if(row.role_id == 3){
                return `<button class="btn btn-sm btn-primary make-admin" data-user_id="${data.id}" disabled>Make Admin</button>
                        <button class="btn btn-sm btn-danger demote-admin" data-user_id="${data.id}"  disabled>Demote Admin</button>`;
              }
              const isAdmin = row.role_id == 2;
              
              // Render buttons for each row
              return `<button class="btn btn-sm btn-primary make-admin" data-user_id="${data.id}" ${isAdmin ? 'disabled' : ''}>Make Admin</button>
                      <button class="btn btn-sm btn-danger demote-admin" data-user_id="${data.id}"  ${isAdmin ? '' : 'disabled'}>Demote Admin</button>`;
            }
          }
        ],
        paging: true,
        searching: true,
        ordering: true,
        lengthChange: true,
        pageLength: 10
    });


    $('#usersTable').on('click', '.make-admin', function() {
        const userId = $(this).data('user_id');
        updateRole(userId, 'admin');
    });

    $('#usersTable').on('click', '.demote-admin', function() {
        const userId = $(this).data('user_id');
        updateRole(userId, 'user');
    });

    function updateRole(userId, newRole) {
        $.ajax({
            url: './../../controllers/update_role.php',
            method: 'POST',
            dataType: 'json',
            data: { id: userId, role: newRole },
            success: function(response) {
                alert("Role updated successfully.");
                table.ajax.reload(null, false);
            },
            error: function() {
                alert('Failed to update role.');
            }
        });
    }

      
    });
  </script>
</body>
</html>
