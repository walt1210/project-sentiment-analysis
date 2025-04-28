<?php
  require_once __DIR__ . '/session.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sentimo — User Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="/project-sentiment-analysis/assets/styles.css?v=2">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="dashboard.php">
        <img src="/project-sentiment-analysis/assets/logo-icon.png" alt="Sentimo icon" height="30">
        <img src="/project-sentiment-analysis/assets/logo-text.png" alt="Sentimo text" height="30">
      </a>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a class="nav-link" href="submit_review.php">Submit Review</a></li>
        <li class="nav-item"><a class="nav-link" href="view_reviews.php">View My Reviews</a></li>
        <li class="nav-item"><a class="nav-link" href="../../logoutController.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
      </ul>
    </div>
  </nav>

  <div class="container mt-4">
    <!-- 1. User Welcome Area -->
    <div class="jumbotron text-center">
      <h1 class="display-4">Welcome, <span id="userFirstName">John</span>!</h1>
    </div>

    <!-- Quick Stats -->
    <div class="row text-center">
      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Total Reviews Given</h5>
            <p class="card-text" id="totalReviews">15</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Positive Sentiments</h5>
            <p class="card-text" id="positiveSentiments">10</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Negative Sentiments</h5>
            <p class="card-text" id="negativeSentiments">5</p>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Total Upvotes</h5>
            <p class="card-text" id="totalUpvotes">25</p>
          </div>
        </div>
      </div>
    </div>

    <!-- 2. Product Recommendations -->
    <h2 class="mt-5">Product Recommendations</h2>
    <div class="row" id="productRecommendations">
      <!-- Sample Product Card -->
      <div class="col-md-4">
        <div class="card">
          <img src="/project-sentiment-analysis/uploads/sample-product.jpg" class="card-img-top" alt="Product Image">
          <div class="card-body">
            <h5 class="card-title">Product Name</h5>
            <p class="card-text">Category: Electronics</p>
            <p class="card-text">Sentiment Score: 85%</p>
            <a href="#" class="btn btn-primary">View Product</a>
          </div>
        </div>
      </div>
    </div>

    <!-- 3. User Review Management -->
    <h2 class="mt-5">My Reviews</h2>
    <table class="table table-striped" id="userReviews">
      <thead>
        <tr>
          <th>Product Name</th>
          <th>Rating</th>
          <th>Review</th>
          <th>Upvotes</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <!-- Sample Review -->
        <tr>
          <td>Superstar II Shoes</td>
          <td>⭐⭐⭐⭐</td>
          <td>Great product!</td>
          <td>10</td>
          <td>
            <button class="btn btn-sm btn-warning">Edit</button>
            <button class="btn btn-sm btn-danger">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- 4. Activity Logs -->
    <h2 class="mt-5">Activity History</h2>
    <table class="table table-striped" id="activityLogs">
      <thead>
        <tr>
          <th>Date/Time</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <!-- Sample Log -->
        <tr>
          <td>2025-04-26 14:30</td>
          <td>Posted a Review</td>
        </tr>
      </tbody>
    </table>
  </div>

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
</body>
</html>
