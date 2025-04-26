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
      <form id="registerForm">
        <input type="text" name="name" placeholder="Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <button type="submit">REGISTER</button>
      </form>
      <div class="footer-links">
        <span>Have a Sentimo account? <a href="login.php">Login</a></span>
      </div>
    </aside>
  </main>

  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script>
    // AJAX for Registration
    $('#registerForm').on('submit', function(e) {
      e.preventDefault();
      const formData = $(this).serialize();

      $.ajax({
        url: './api/register_user.php', // Backend endpoint for registration
        method: 'POST',
        data: formData,
        success: function(response) {
          alert(response.message); // Show success or error message
          if (response.success) {
            window.location.href = 'login.php'; // Redirect to login on success
          }
        },
        error: function() {
          alert('An error occurred. Please try again.');
        }
      });
    });
  </script>
</body>
</html>
