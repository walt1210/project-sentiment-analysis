<?php
  require_once __DIR__ . '/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sentimo — Submit Review</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
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
        <li class="nav-item"><a class="nav-link" href="submit_review.php">Submit Review</a></li>
        <li class="nav-item"><a class="nav-link" href="view_reviews.php">View My Reviews</a></li>
        <li class="nav-item"><a class="nav-link" href="../../logoutController.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
      </ul>
    </div>
  </nav>

  <main class="submitReview-page">

    <!-- 1) hero GIF -->
    <section class="hero">
      <img src="/project-sentiment-analysis/assets/submit-review-hero.gif" alt="Sentimo Submit Review">
    </section>

     <!-- 2) Submit Review Form -->
     <h2>Review a Product</h2>
     <section class="review-wrapper">
      <div class="review-card">
        <h2>Review Form</h2>
        <p class="subhead">Write your Review</p>
        <form action="#" method="POST">
          <select name="product" required> <!-- SAMPLES LANG ITO, IGGET ANG PRODUCTS FROM add_products.php -->
            <option value="" disabled selected>Product</option>
            <option value="superstar">Superstar II Shoes</option>
            <option value="tshirt">Cotton T-Shirt</option>
            <option value="pants">Ultra Stretch Pants</option>
            <option value="cap">Varsity Cap</option>
          </select>

          <div class="rating">
            <input type="radio" id="star5" name="rating" value="5"/><label for="star5">★</label>
            <input type="radio" id="star4" name="rating" value="4"/><label for="star4">★</label>
            <input type="radio" id="star3" name="rating" value="3"/><label for="star3">★</label>
            <input type="radio" id="star2" name="rating" value="2"/><label for="star2">★</label>
            <input type="radio" id="star1" name="rating" value="1"/><label for="star1">★</label>
          </div>

          <textarea name="review" rows="6" placeholder="Review" required></textarea>

          <button type="submit">SUBMIT REVIEW</button>
        </form>
      </div>
    </section>

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
