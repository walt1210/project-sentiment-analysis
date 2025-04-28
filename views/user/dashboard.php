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
        <li class="nav-item"><a class="nav-link" href="/project-sentiment-analysis/index.php">Logout</a></li>
      </ul>
    </div>
  </nav>

  <div class="container mt-4">
    <!-- 1. Hero GIF -->
    <section class="hero">
      <img src="/project-sentiment-analysis/assets/dashboard-hero.gif" alt="Sentimo Dashboard Overview" class="img-fluid">
    </section>

    <!-- 2. User Welcome Area -->
    <div class="jumbotron text-center mt-4">
      <h1 class="display-4">User: <span id="userFirstName">John</span></h1>
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

    <!-- Search Bar and Category Dropdown -->
    <div class="row mt-4">
      <div class="col-md-8">
        <input type="text" id="searchInput" class="form-control" placeholder="Search products...">
      </div>
      <div class="col-md-4">
        <select id="categoryDropdown" class="form-select">
          <option value="all">All Categories</option>
          <option value="fashion">Fashion</option>
          <option value="electronics">Electronics</option>
          <option value="home">Home & Living</option>
          <option value="sports">Sports</option>
          <option value="beauty">Beauty</option>
        </select>
      </div>
    </div>

    <!-- Product Recommendations -->
    <div class="row mt-4" id="productRecommendations">
      <!-- Sample Product Card -->
      <?php
      // Sample products array (replace with dynamic data from the database)
      $products = [
        ['id' => 1, 'name' => 'Superstar II Shoes', 'category' => 'Fashion', 'sentiment_score' => 85, 'image' => 'superstar-shoes.jpg'],
        ['id' => 2, 'name' => 'Smartphone X', 'category' => 'Electronics', 'sentiment_score' => 90, 'image' => 'smartphone-x.jpg']
      ];

      foreach ($products as $product) {
        echo '<div class="col-md-4">
                <div class="card">
                  <img src="/project-sentiment-analysis/uploads/' . htmlspecialchars($product['image']) . '" class="card-img-top" alt="' . htmlspecialchars($product['name']) . '">
                  <div class="card-body">
                    <h5 class="card-title">' . htmlspecialchars($product['name']) . '</h5>
                    <p class="card-text">Category: ' . htmlspecialchars($product['category']) . '</p>
                    <p class="card-text">Sentiment Score: ' . htmlspecialchars($product['sentiment_score']) . '%</p>
                    <button class="btn btn-primary view-product" data-id="' . htmlspecialchars($product['id']) . '" data-name="' . htmlspecialchars($product['name']) . '">View Product</button>
                  </div>
                </div>
              </div>';
      }
      ?>
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
          <h5 id="modalProductName"></h5>
          <div id="productComments">
            <!-- Existing comments will be loaded here dynamically -->
          </div>
          <hr>
          <h6>Add a Comment</h6>
          <form id="addCommentForm">
            <div class="mb-3">
              <textarea class="form-control" id="commentText" name="comment" rows="3" placeholder="Write your comment here..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Comment</button>
          </form>
        </div>
      </div>
    </div>
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
  <script>
    $(document).ready(function() {
      // Handle "View Product" button click
      $('.view-product').on('click', function() {
        const productId = $(this).data('id');
        const productName = $(this).data('name');

        // Set product name in the modal
        $('#modalProductName').text(productName);

        // Fetch existing comments via AJAX
        $.ajax({
          url: '/project-sentiment-analysis/api/get_product_comments.php', 
          method: 'GET',
          data: { product_id: productId },
          success: function(response) {
            let commentsHtml = '';
            response.comments.forEach(comment => {
              commentsHtml += `
                <div class="mb-3">
                  <strong>${comment.user_name}</strong>
                  <p><strong>Rating:</strong> ${'⭐'.repeat(comment.rating)} (${comment.rating}/5)</p>
                  <p><strong>Review:</strong> ${comment.comment}</p>
                  <p><strong>Sentiment:</strong> ${comment.sentiment}</p>
                  <small class="text-muted">${comment.date}</small>
                </div>
                <hr>`;
            });
            $('#productComments').html(commentsHtml);
          },
          error: function() {
            $('#productComments').html('<p class="text-danger">Failed to load comments. Please try again later.</p>');
          }
        });

        // Show the modal
        $('#productReviewModal').modal('show');
      });

      // Handle comment submission
      $('#addCommentForm').on('submit', function(e) {
        e.preventDefault();
        const commentData = {
          product_id: $('#modalProductName').data('id'),
          comment: $('#commentText').val()
        };

        // Submit the comment via AJAX
        $.ajax({
          url: '/project-sentiment-analysis/api/add_product_comment.php', // Backend endpoint to add a comment
          method: 'POST',
          data: commentData,
          success: function(response) {
            if (response.success) {
              alert('Comment added successfully!');
              $('#commentText').val(''); 
              $('#productComments').append(`
                <div class="mb-3">
                  <strong>You</strong>
                  <p><strong>Rating:</strong> ⭐⭐⭐⭐⭐ (5/5)</p>
                  <p><strong>Review:</strong> ${commentData.comment}</p>
                  <p><strong>Sentiment:</strong> Positive</p>
                  <small class="text-muted">Just now</small>
                </div>
                <hr>`);
            } else {
              alert('Failed to add comment. Please try again.');
            }
          },
          error: function() {
            alert('An error occurred. Please try again.');
          }
        });
      });

      // Filter products based on search input
      $('#searchInput').on('keyup', function() {
        const searchValue = $(this).val().toLowerCase();
        $('#productRecommendations .card').filter(function() {
          $(this).parent().toggle($(this).text().toLowerCase().indexOf(searchValue) > -1);
        });
      });

      // Filter products based on category dropdown
      $('#categoryDropdown').on('change', function() {
        const selectedCategory = $(this).val().toLowerCase();
        $('#productRecommendations .card').filter(function() {
          if (selectedCategory === 'all') {
            $(this).parent().show();
          } else {
            $(this).parent().toggle($(this).find('.card-text:contains("Category:")').text().toLowerCase().includes(selectedCategory));
          }
        });
      });
    });
  </script>
</body>
</html>