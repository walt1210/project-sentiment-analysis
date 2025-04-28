<?php
  require_once __DIR__ . '/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sentimo — View Reviews</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
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

  <main class="viewReview-page">
    <!-- 1) Hero GIF -->
    <section class="hero">
      <img src="/project-sentiment-analysis/assets/view-reviews-hero.gif" alt="Sentimo View Reviews" class="img-fluid">
    </section>

    <!-- 2) Reviews Table -->
    <h2 class="mt-5">My Product Reviews</h2>
    <div class="table-wrapper">
      <table id="reviewsTable" class="table table-striped table-bordered" style="width:100%">
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
          <!-- Sample Reviews -->
          <tr>
            <td>Superstar II Shoes</td>
            <td>Great product! Very comfortable.</td>
            <td>⭐⭐⭐⭐</td>
            <td>Positive</td>
            <td>
              <button class="btn btn-sm btn-warning edit-review" data-id="1">Edit</button>
              <button class="btn btn-sm btn-danger delete-review" data-id="1">Delete</button>
            </td>
          </tr>
          <tr>
            <td>Smartphone X</td>
            <td>Good performance but battery life could be better.</td>
            <td>⭐⭐⭐</td>
            <td>Neutral</td>
            <td>
              <button class="btn btn-sm btn-warning edit-review" data-id="2">Edit</button>
              <button class="btn btn-sm btn-danger delete-review" data-id="2">Delete</button>
            </td>
          </tr>
          <tr>
            <td>Ultra Stretch Pants</td>
            <td>Perfect fit and very durable.</td>
            <td>⭐⭐⭐⭐⭐</td>
            <td>Positive</td>
            <td>
              <button class="btn btn-sm btn-warning edit-review" data-id="3">Edit</button>
              <button class="btn btn-sm btn-danger delete-review" data-id="3">Delete</button>
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

  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
  <script>
    $(document).ready(function() {
      // Initialize DataTable
      $('#reviewsTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        lengthChange: true,
        pageLength: 5 // Display 5 reviews per page
      });

      // Handle delete review
      $('.delete-review').on('click', function() {
        const reviewId = $(this).data('id');
        if (confirm('Are you sure you want to delete this review?')) {
          alert('Review with ID ' + reviewId + ' deleted (sample action).');
          // Backend integration: Replace this alert with an AJAX call to delete the review
        }
      });

      // Handle edit review
      $('.edit-review').on('click', function() {
        const reviewId = $(this).data('id');
        alert('Edit review with ID ' + reviewId + ' (sample action).');
        // Backend integration: Redirect to an edit review page or open a modal for editing
      });
    });
  </script>
</body>
</html>
