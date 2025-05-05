<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sentimo — Forgot Password</title>
  <link rel="stylesheet" href="./assets/styles.css?v=2">
</head>
<body>
  <nav class="navbar">
    <div class="logo">
        <a href="index.php" class="logo">
            <img src="./assets/logo-icon.png" alt="Sentimo icon">
            <img src="./assets/logo-text.png" alt="Sentimo text">
        </a>
    </div>
    <ul class="nav-links">
      <li><a href="about.php">About</a></li>
      <li><a href="creators.php">Creators</a></li>
    </ul>
  </nav>

  <main class="resetPassword-page">
  <a href="javascript:history.back()" class="back-button" aria-label="Go back">
    ←
  </a>
   <!--Reset Password Form-->
   <aside class="login-card">
      <h2>Reset Password</h2>
      <p class="subhead">Set a new password</p>
      <form id="forgot_password_form">
        <input type="email"   name="email"       id="email"         placeholder="Email"                required>
        <!-- <input type="password"name="new_password"         placeholder="New Password"         required>
        <input type="password"name="confirm_new_password" placeholder="Confirm New Password" required> -->
        <button type="submit">CONFIRM</button> <!--Redirect to login.php-->
      </form>
    </aside>
  </main>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script>
 $(document).ready(function() {
    // AJAX for Reset Password
    $('#forgot_password_form').on('submit', function(e) {
        e.preventDefault();
        alert($(this).serialize());
        $.ajax({
            type: 'POST',
            method: 'POST',
            url: './controllers/forgot_password/forgot_password_controller.php',
            dataType: 'json',
            data: $(this).serialize(),
            success: function(response) {
               alert($(this).serialize());
                alert(response.message); // Handle success response
                window.location.href = "login.php"; // Redirect to login page
            },
            error: function(xhr, status, error) {
              
                alert("An error occurred: " + error); // Handle error response
            }
        });
    });
  });
</script>
</html>
