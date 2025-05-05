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
        <form id="reset-form">
            <input type="password" name="new_password" placeholder="Enter new password" required>
            <button type="submit">Reset Password</button>
        </form>
    </aside>
    <div id="reset-response"></div>




  </main>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script>
  // Get token from URL
  const urlParams = new URLSearchParams(window.location.search);
  const token = urlParams.get('token');

  if (!token) {
    $('#reset-form').hide();
    $('#reset-response').html('<p>Missing token.</p>');
  }

  $('#reset-form').on('submit', function(e) {
    e.preventDefault();
    $('#reset-response').html('Processing...');
    console.log($('input[name=new_password]').val());
    console.log(token);

    $.ajax({
      url: './controllers/forgot_password/reset_password_controller.php',
      type: 'POST',
      method: 'POST',
      data: {
        'token': token,
        new_password: $('input[name=new_password]').val()
      },
      dataType: 'json',
      success: function(res) {
        $('#reset-response').html('<p>' + res.message + '</p>');
        if (res.status === 'success') {
          $('#reset-form').hide();
        }
      },
      error: function() {
        $('#reset-response').html('<p>Error resetting password.</p>');
      }
    });
  });
</script>
</html>
