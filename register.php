<?php
  require_once __DIR__ . '/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sentimo — Register</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="./assets/styles.css?v=2">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="index.php">
        <img src="./assets/logo-icon.png" alt="Sentimo icon" height="30">
        <img src="./assets/logo-text.png" alt="Sentimo text" height="30">
      </a>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="creator.php">Creators</a></li>
      </ul>
    </div>
  </nav>

  <main class="registration-page">
    <div class="graphic">
      <img src="./assets/logo-full.png" alt="Sentimo graphic">
    </div>

    <!-- Registration Form -->
    <aside class="login-card">
      <h2>Register</h2>
      <p class="subhead">Register your account</p>
      <form id="registerForm" method="POST">
        <input type="text" name="fname" id="fname" placeholder="First Name" required>
        <input type="text" name="lname" id="lname" placeholder="Last Name" required>
        <input type="email" name="email" id="email" placeholder="Email" required>
        <input type="password" name="password" id="password" placeholder="Password" minlength="8" required>
        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" minlength="8" required>
        <button type="submit">REGISTER</button>
      </form>
      <div class="footer-links">
        <span>Have a Sentimo account? <a href="login.php">Login</a></span>
      </div>
    </aside>
  </main>

  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script>
    window.addEventListener('pageshow', function (event) {
      if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
        location.reload(); // Reloads page and re-triggers PHP
      }
    });

    // AJAX for Registration
    $('#registerForm').on('submit', function(e) {
      e.preventDefault();
      const formData = $(this).serialize();
      //console.log(formData);

      if($('#password').val() == $('#confirm_password').val()){
        $.ajax({
        url: 'controllers/RegisterController.php', // Backend endpoint for registration
        type: 'POST',
        method: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
          alert(response.success); // Show success or error message
          //console.log(response);
          if (response.success) {
            window.location.href = 'login.php'; // Redirect to login on success
          }
          else{
            var err_msg = '';
            var errors = response.errors;
            errors.forEach(error_txt => {
              err_msg = err_msg.concat(" ", error_txt);
            });
            alert(err_msg);
          }
        },
        error: function() {
          alert('An error occurred. Please try again.');
        }
      });
      }
      else{
        alert('Passwords do not match. Try again.');
      }
    });
  </script>
</body>
</html>
