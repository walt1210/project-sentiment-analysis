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

  <main class="viewReview-page">
    <!-- 1) Hero GIF -->
    <section class="hero">
      <img src="../../assets/view-reviews-hero.gif" alt="Sentimo View Reviews" class="img-fluid">
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

  <!-- Edit Review Modal -->
  <div class="modal fade" id="editReviewModal" tabindex="-1" aria-labelledby="editReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editReviewModalLabel">Edit Review</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Edit Review Form -->
          <form id="editReviewForm" action="#" method="POST">
            <input type="hidden" id="reviewId" name="review_id"> <!-- Hidden field for review ID -->
            <div class="mb-3">
              <label for="productName" class="form-label">Product</label>
              <input type="text" id="productName" class="form-control" name="product_name" readonly>
            </div>
            <div class="mb-3">
              <label class="form-label">Rating</label>
              <div class="rating">
                <input type="radio" id="editStar5" name="rating" value="5"><label for="editStar5">★</label>
                <input type="radio" id="editStar4" name="rating" value="4"><label for="editStar4">★</label>
                <input type="radio" id="editStar3" name="rating" value="3"><label for="editStar3">★</label>
                <input type="radio" id="editStar2" name="rating" value="2"><label for="editStar2">★</label>
                <input type="radio" id="editStar1" name="rating" value="1"><label for="editStar1">★</label>
              </div>
            </div>
            <div class="mb-3">
              <label for="reviewText" class="form-label">Review</label>
              <textarea id="reviewText" class="form-control" name="review" rows="6" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Edit Review</button>
          </form>
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
  <script>
    $(document).ready(function () {
      // Handle Edit Review Button Click
      $('.edit-review').on('click', function () {
        const reviewId = $(this).data('id');

        // Fetch review details via AJAX
        $.ajax({
          url: '/project-sentiment-analysis/api/get_review.php', // Adjust the path to your API
          method: 'GET',
          data: { id: reviewId },
          success: function (response) {
            if (response.success) {
              // Populate the modal with review data
              $('#reviewId').val(response.review.id);
              $('#productName').val(response.review.product_name);
              $(`input[name="rating"][value="${response.review.rating}"]`).prop('checked', true);
              $('#reviewText').val(response.review.comment);

              // Show the modal
              $('#editReviewModal').modal('show');
            } else {
              alert('Failed to fetch review details.');
            }
          },
          error: function () {
            alert('An error occurred while fetching review details.');
          },
        });
      });

      // Handle Edit Review Form Submission
      $('#editReviewForm').on('submit', function (e) {
        e.preventDefault();

        const formData = $(this).serialize();

        // Submit the edited review via AJAX
        $.ajax({
          url: '/project-sentiment-analysis/api/edit_review.php', // Adjust the path to your API
          method: 'POST',
          data: formData,
          success: function (response) {
            if (response.success) {
              alert('Review updated successfully.');
              $('#editReviewModal').modal('hide');
              location.reload(); // Reload the page to reflect changes
            } else {
              alert('Failed to update review.');
            }
          },
          error: function () {
            alert('An error occurred while updating the review.');
          },
        });
      });
    });
  </script>
</body>
</html>
