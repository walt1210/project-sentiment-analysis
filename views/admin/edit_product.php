<?php
  require_once __DIR__ . '/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sentimo — Edit Product</title>
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
          <li class="nav-item"><a class="nav-link" href="add_products.php">Add Product</a></li>
          <li class="nav-item"><a class="nav-link" href="view_users.php">View Users</a></li>
          <li class="nav-item"><a class="nav-link" href="../../logoutController.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
        </ul>
      </div>
    </nav>

  <main class="addProduct-page">

    <!-- 2) Edit Product Form -->
    <section class="addProduct-wrapper">
      <div class="addProduct-card">
        <h2>Edit Product Form</h2>
        <p class="subhead">Edit the product details</p>
        <form id="editProductForm" enctype="multipart/form-data">
          <!-- Product Name -->
          <input type="text" id="product_name" name="product_name" placeholder="Product Name" required>

          <!-- Price -->
          <input type="text" id="price" name="price" placeholder="Price" required>

          <!-- Category Dropdown -->
          <div class="form-group">
            <select id="category" name="category" class="form-control" required>
              <option value="">Select Category</option>
              <!-- Categories will be dynamically populated -->
            </select>
          </div>

          <!-- Image Upload -->
          <label for="image-upload" class="upload-box">
            <img src="/project-sentiment-analysis/assets/upload-image-icon.png" alt="Upload Icon" id="preview-icon">
            <span id="upload-text">Upload Image<br><small>in .png format</small></span>
            <input type="file" id="image-upload" name="product_image" accept=".png" hidden>
          </label>
          <img id="image-preview" src="#" alt="Image Preview" style="display: none; max-width: 100%; margin-top: 10px;">

          <!-- Submit Button -->
          <button type="submit" class="btn btn-primary">UPDATE PRODUCT</button>
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

  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function () {
      // Fetch product details and populate the form
      function fetchProductDetails(productId) {
        $.ajax({
          url: '/project-sentiment-analysis/api/get_product.php', // Adjust the path to your API
          method: 'GET',
          data: { id: productId },
          success: function (response) {
            if (response.success) {
              // Populate the form fields with product data
              $('#product_name').val(response.product.name);
              $('#price').val(response.product.price);
              $('#category').val(response.product.category_id);
              if (response.product.image) {
                $('#image-preview').attr('src', response.product.image).show();
                $('#preview-icon').hide();
                $('#upload-text').hide();
              }
            } else {
              alert('Failed to fetch product details.');
            }
          },
          error: function () {
            alert('An error occurred while fetching product details.');
          },
        });
      }

      // Fetch categories and populate the dropdown
      function fetchCategories() {
        $.ajax({
          url: '/project-sentiment-analysis/api/get_categories.php', // Adjust the path to your API
          method: 'GET',
          success: function (response) {
            if (response.success) {
              response.categories.forEach(function (category) {
                $('#category').append(`<option value="${category.id}">${category.name}</option>`);
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

      // Get the product ID from the URL query string
      const urlParams = new URLSearchParams(window.location.search);
      const productId = urlParams.get('id');

      if (productId) {
        fetchProductDetails(productId); // Fetch product details
        fetchCategories(); // Fetch categories
      } else {
        alert('No product ID provided.');
      }

      // Handle Edit Product Form Submission
      $('#editProductForm').on('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('id', productId); // Include the product ID

        $.ajax({
          url: '/project-sentiment-analysis/api/update_product.php', // Adjust the path to your API
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
            if (response.success) {
              alert('Product updated successfully.');
              window.location.href = 'dashboard.php'; // Redirect to dashboard
            } else {
              alert('Failed to update product. Please try again.');
            }
          },
          error: function () {
            alert('An error occurred. Please try again.');
          },
        });
      });
    });
  </script>
</body>
</html>