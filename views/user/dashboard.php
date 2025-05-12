<?php
  require_once __DIR__ . '/session.php';
?> 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sentimo — User Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
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
        <li class="nav-item"><a class="nav-link" href="submit_review.php">Submit Review</a></li>
        <li class="nav-item"><a class="nav-link" href="view_reviews.php">View My Reviews</a></li>
        <li class="nav-item"><a class="nav-link" href="../../logoutController.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
      </ul>
    </div>
  </nav>

  <!-- 1. Hero GIF -->
  <section class="hero">
      <img src="../../assets/dashboard-hero.gif" alt="Sentimo Dashboard Overview" class="img-fluid">
    </section>

  <div class="container mt-4">

        <!-- 2. User Welcome Area -->
        <div class="jumbotron text-center mt-4">
        <h1 class="display-4">User: <span id="userFirstName"><?php echo $_SESSION["first_name"]. " ". $_SESSION["last_name"] ?></span></h1>
        </div>

        <!-- Search Bar and Category Dropdown -->
        <div class="row mt-4">
            <div class="col-md-8">
                <input type="text" id="searchInput" class="form-control" placeholder="Search products...">
            </div>
            <div class="col-md-4">
                <select id="categoryDropdown" class="form-select">
                <!-- Categories will be dynamically populated here added by the super admin -->
                </select>
            </div>
        </div>

    <!-- Product Recommendations -->
        <div class="row mt-4" id="productRecommendations">
            <!-- Sample Product Cards -->
        </div>
  </div>

  <!-- Product Review Modal -->
  <div class="modal fade" id="productReviewModal" tabindex="-1" aria-labelledby="productReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="productReviewModalLabel">Product Reviews</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Product Details -->
          <div class="row mb-4">
            <div class="col-md-4">
              <img id="modalProductImage" src="" alt="Product Image" class="img-fluid rounded">
            </div>
            <div class="col-md-8">
              <h5 id="modalProductName"></h5>
              <p id="modalProductCategory" class="text-muted"></p>
              <div class="d-flex align-items-center">
                <button id="likeButton" class="reaction-btn btn btn-success btn-sm me-2">
                  👍 Like <span id="likeCount" class="badge bg-light text-dark">0</span>
                </button>
                <button id="unlikeButton" class="reaction-btn btn btn-danger btn-sm me-2">
                  👎 Unlike <span id="unlikeCount" class="badge bg-light text-dark">0</span>
                </button>
                <button id="btnComment" class="btn btn-primary btn-sm comment">
                    Comment
                </button>
                  
              </div>
            </div>
          </div>

          <hr>

          <!-- User Reviews -->
          <div id="productComments">
            <!-- Sample Reviews -->
          </div>
        </div>
      </div>
    </div>
  </div>

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
  <script src="../../assets/js/user-dashboard.js"></script>
</body>
</html>