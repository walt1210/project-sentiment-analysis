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
            <th>Category</th>
            <th>Review</th>
            <th>Rating</th>
            <th>Sentiment</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Sample Reviews -->
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
    window.addEventListener('pageshow', function (event) {
      if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
        location.reload(); // Reloads page and re-triggers PHP
      }
    });



    
    $(document).ready(function() {
      // Initialize DataTable
      $('#reviewsTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
          url: './../../controllers/get_prod_revs_user.php', // Adjust the path to your API
          type: 'GET',
          dataSrc: function(json) {
            if(json.success){
              return json.data; // Return the data array from the response
            } else {
              alert('No reviews found.');
              return []; // Return an empty array if no reviews found
            }
         }
        },
        columns: [
          { data: 'product_name', render: function(data) {
              return data.replace(/\b\w/g, char => char.toUpperCase()); // Capitalize first letter of each word
            }
          },
          { data: 'category_name', render: function(data) {
              return data.replace(/\b\w/g, char => char.toUpperCase()); // Capitalize first letter of each word
            }
          },
          { data: 'review_text' },
          { data: 'rating', render: function(data) {
              return '⭐'.repeat(data); // Render stars based on rating
            }
          },
          { data: 'type', render: function(data) {
              return data.charAt(0).toUpperCase() + data.slice(1); // Capitalize first letter of sentiment type
            }
          },
          { data: 'id', render: function(data) {
              return `<button class="btn btn-sm btn-warning edit-review" data-id="${data}">Edit</button>
                      <button class="btn btn-sm btn-danger delete-review" data-id="${data}">Delete</button>`;
            }
          }
        ],
        paging: true,
        searching: true,
        ordering: true,
        lengthChange: true,
        pageLength: 5 // Display 5 reviews per page
      });



      $('#reviewsTable tbody').on('click', '.edit-review', function() {
        let dataId = $(this).attr('data-id');
        //alert("Button clicked for ID: " + dataId);
        // Fetch review details via AJAX
        $.ajax({
          url: './../../controllers/get_one_prod_rev.php', // Adjust the path to your API
          method: 'GET',
          data: { id: dataId },
          dataType: 'json',
          success: function (response) {
            if (response.success) {
              // Populate the modal with review data
              $('#reviewId').val(response.review.id);
              $('#productName').val(response.review.product_name.replace(/\b\w/g, char => char.toUpperCase()));
              $(`input[name="rating"][value="${response.review.rating}"]`).prop('checked', true);
              $('#reviewText').val(response.review.review_text);

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

        const formData = $(this).serialize()  + "&action=" + encodeURIComponent("edit"); // Serialize the form data
        // Submit the edited review via AJAX
        $.ajax({
          url: './../../controllers/submit_review_controller.php', // Adjust the path to your API
          method: 'POST',
          data: formData,
          dataType: 'json',
          success: function (response) {
            if(response.success) {
              alert(response.msg);
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



      //delete review
      $('#reviewsTable tbody').on('click', '.delete-review', function() {
        let dataId = $(this).attr('data-id');
        //alert("Button clicked for ID: " + dataId);


        if(confirm('Are you sure you want to delete?')){
          $.ajax({
          url: './../../controllers/submit_review_controller.php', // Adjust the path to your API
          method: 'POST',
          data:   { action:"delete", review_id: dataId },
          dataType: 'json',
          success: function (response) {
            if(response.success) {
              alert(response.msg);
              $('#editReviewModal').modal('hide');
              location.reload(); // Reload the page to reflect changes
            } else {
              alert('Failed to delete review.');
            }
          },
          error: function () {
            alert('An error occurred while deleting the review.');
          },
        });
        }
        
      });

 });
  </script>
</body>
</html>
