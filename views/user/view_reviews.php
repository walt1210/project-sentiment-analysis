<?php
  require_once __DIR__ . '/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sentimo — View Reviews</title>
  <link rel="stylesheet" href="/project-sentiment-analysis/assets/styles.css?v=2">
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
        <li><a href="submit_review.php">Submit Review</a></li>
        <li><a href="view_reviews.php">View My Reviews</a></li>
        <li><a href="../../logoutController.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
    </ul>
  </nav>

  <main class="viewReview-page">

    <!-- 1) hero GIF -->
    <section class="hero">
      <img src="/project-sentiment-analysis/assets/view-reviews-hero.gif" alt="Sentimo View Reviews">
    </section>

     <!-- 2) Edit Review Form -->
     <h2>My Product Reviews</h2>
     <section class="review-wrapper">
      <div class="review-card">
        <h2>Edit Review Form</h2>
        <p class="subhead">Edit your Review</p>
        <form action="#" method="POST">
          <select name="product" required>
            <option value="" disabled selected>Product</option>
            <option value="superstar">Superstar II hoes</option>
            <option value="tshirt">Cotton T-Shirt</option>
            <option value="pants">Ultra Stretch Pants</option>
            <option value="cap">Varsity Cap</option>
          </select>

          <div class="rating">
            <!-- reverse order so CSS sibling selectors light up correctly -->
            <input type="radio" id="star5" name="rating" value="5"/><label for="star5">★</label>
            <input type="radio" id="star4" name="rating" value="4"/><label for="star4">★</label>
            <input type="radio" id="star3" name="rating" value="3"/><label for="star3">★</label>
            <input type="radio" id="star2" name="rating" value="2"/><label for="star2">★</label>
            <input type="radio" id="star1" name="rating" value="1"/><label for="star1">★</label>
          </div>

          <textarea name="review" rows="6" placeholder="Review" required></textarea>

          <button type="submit">EDIT REVIEW</button>
        </form>
      </div>
    </section>
    <!-- 3) Reviews Table -->
      <!-- Reviews table -->
  <div class="table-wrapper">
    <table class="reviews-table">
      <thead>
        <tr>
          <th>Product</th>
          <th>Review</th>
          <th>Rating</th>
          <th>Sentiment</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <!-- GENERATED ROWS (sample only) -->
        <tr>
            <td>Hakdog</td>
            <td>Okay lang</td>
            <td><!-- Stars from submit_review.php --></td>
            <td><!-- Positive/Negative/Neutral --></td>
            <td>
              <button class="action-btn edit">Edit</button>
              <button class="action-btn delete">Delete</button>
            </td>
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
</body>
</html>
