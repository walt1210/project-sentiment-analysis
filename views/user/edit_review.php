<?php
  require_once __DIR__ . '/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sentimo — Edit Review</title>
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

  <main class="submitReview-page">

    <!-- 1) hero GIF -->
    <section class="hero">
      <img src="../../assets/submit-review-hero.gif" alt="Sentimo Submit Review">
    </section>

     <!-- 2) Submit Review Form -->
     <h2>Edit My Review</h2>
     <section class="review-wrapper">
      <div class="review-card">
        <h2>Edit Review Form</h2>
        <p class="subhead">Edit your Review</p>
        <form action="#" method="POST">
          <!-- Category Dropdown -->
          <div class="mb-3">
            <label for="categoryDropdown" class="form-label">Category</label>
            <select id="categoryDropdown" name="category" class="form-select" required>
              <option value="" disabled selected>Select Category</option>
              <!-- Categories will be dynamically populated here -->
            </select>
          </div>

          <!-- Product Name Dropdown -->
          <div class="mb-3">
            <label for="productDropdown" class="form-label">Product</label>
            <select id="productDropdown" name="product" class="form-select" required>
              <option value="" disabled selected>Select Product</option>
              <!-- Products will be dynamically populated based on the selected category -->
            </select>
          </div>

          <!-- Rating -->
          <label class="form-label">Rating</label>
          <div class="rating mb-3">
          <input type="radio" id="star5" name="rating" value="5"/><label for="star5">★</label>
            <input type="radio" id="star4" name="rating" value="4"/><label for="star4">★</label>
            <input type="radio" id="star3" name="rating" value="3"/><label for="star3">★</label>
            <input type="radio" id="star2" name="rating" value="2"/><label for="star2">★</label>
            <input type="radio" id="star1" name="rating" value="1"/><label for="star1">★</label>
          </div>

          <!-- Review Text -->
          <div class="mb-3">
            <label for="reviewText" class="form-label">Review</label>
            <textarea id="reviewText" name="review" class="form-control" rows="6" placeholder="Write your review here..." required></textarea>
          </div>

          <!-- Submit Button -->
          <button type="submit" class="btn btn-primary">Edit Review</button>
        </form>
      </div>
    </section>

  </main>

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

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
      // Fetch categories from the backend
      function fetchCategories() {
        $.ajax({
          url: '/project-sentiment-analysis/api/get_categories.php', // Adjust the path to your API
          method: 'GET',
          success: function (response) {
            if (response.success) {
              const categoryDropdown = $('#categoryDropdown');
              categoryDropdown.empty();
              categoryDropdown.append('<option value="" disabled selected>Select Category</option>');
              response.categories.forEach(function (category) {
                categoryDropdown.append(`<option value="${category.id}">${category.name}</option>`);
              });
            } else {
              alert('Failed to fetch categories.');
            }
          },
          error: function () {
            alert('An error occurred while fetching categories.');
          },
        });
      }

      // Fetch products based on the selected category
      $('#categoryDropdown').on('change', function () {
        const categoryId = $(this).val();
        $.ajax({
          url: '/project-sentiment-analysis/api/get_products.php', // Adjust the path to your API
          method: 'GET',
          data: { category_id: categoryId },
          success: function (response) {
            if (response.success) {
              const productDropdown = $('#productDropdown');
              productDropdown.empty();
              productDropdown.append('<option value="" disabled selected>Select Product</option>');
              response.products.forEach(function (product) {
                productDropdown.append(`<option value="${product.id}">${product.name}</option>`);
              });
            } else {
              alert('Failed to fetch products.');
            }
          },
          error: function () {
            alert('An error occurred while fetching products.');
          },
        });
      });

      // Initialize categories on page load
      fetchCategories();
    });
  </script>
</body>
</html>
