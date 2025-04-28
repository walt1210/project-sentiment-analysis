<?php
  require_once __DIR__ . '/session.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sentimo — Add Products</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/styles.css?v=2">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="superAdmin_dashboard.php">
          <img src="../../assets/logo-icon-light.png" alt="Sentimo icon" height="50">
          <img src="../../assets/logo-text-light.png" alt="Sentimo text" height="50">
      </a>
      <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a class="nav-link">
              <img src="../../assets/super-admin-icon.png" alt="Super Admin Icon" height="40" style="margin-right: 5px;">
              <strong>Super Admin</strong>
            </a>
          </li>
      </ul>
      <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a class="nav-link" href="superAdmin_add_products.php">Add Product</a></li>
          <li class="nav-item"><a class="nav-link" href="manage_users.php">Manage Users</a></li>
          <li class="nav-item"><a class="nav-link" href="../../logoutController.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
      </ul>
    </div>
</nav>

  <main class="addProduct-page">

    <!-- 1) Hero GIF -->
    <section class="hero">
      <img src="/project-sentiment-analysis/assets/add-product-gif.gif" alt="Sentimo Add Product">
    </section>

    <!-- 2) Add Product Form -->
    <section class="addProduct-wrapper">
      <div class="addProduct-card">
        <h2>Add Product Form</h2>
        <p class="subhead">Add a new product</p>
        <form id="addProductForm" enctype="multipart/form-data">
          <!-- Product Name -->
          <input type="text" name="product_name" placeholder="Product Name" required>

          <!-- Price -->
          <input type="text" name="price" placeholder="Price" required>

          <!-- Category Dropdown -->
          <div class="form-group">
            <select id="category" name="category" class="form-control" required>
              <option value="">Select Category</option>
              <option value="add_new">Add New Category</option>
            </select>
          </div>

          <!-- Add New Category Input (Hidden by Default) -->
          <div id="newCategoryWrapper" style="display: none; margin-top: 10px;">
            <input type="text" id="newCategory" name="new_category" placeholder="Enter New Category">
          </div>

          <!-- Image Upload -->
          <label for="image-upload" class="upload-box">
            <img src="/project-sentiment-analysis/assets/upload-image-icon.png" alt="Upload Icon" id="preview-icon">
            <span id="upload-text">Upload Image<br><small>in .png format</small></span>
            <input type="file" id="image-upload" name="product_image" accept=".png" hidden required>
          </label>
          <img id="image-preview" src="#" alt="Image Preview" style="display: none; max-width: 100%; margin-top: 10px;">

          <!-- Submit Button -->
          <button type="submit" class="btn btn-primary">ADD PRODUCT</button>
        </form>
      </div>
    </section>
  </main>

  <footer class="site-footer" style="background-color: #343a40; color: #f8f9fa; padding: 20px; text-align: center;">
    <div class="logo-small" style="margin-left: 20px;">
      <img src="../../assets/logo-icon-light.png" alt="">
      <img src="../../assets/logo-text-light.png" alt="">
    </div>
    <ul class="footer-links">
      <li><a href="../../about.php" style="color: #f8f9fa; text-decoration: none;">About</a></li>
      <li><a href="../../creators.php" style="color: #f8f9fa; text-decoration: none;">Creators</a></li>
    </ul>
  </footer>

  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script>
    $(document).ready(function() {
      // Handle image preview
      $('#image-upload').on('change', function(event) {
        const file = event.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function(e) {
            $('#image-preview').attr('src', e.target.result).show(); 
            $('#preview-icon').hide(); 
            $('#upload-text').show();
          };
          reader.readAsDataURL(file); 
        } else {
          $('#image-preview').hide(); 
          $('#preview-icon').show(); 
          $('#upload-text').show(); 
        }
      });

      // Handle Add Product Form Submission
      $('#addProductForm').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        $.ajax({
          url: '/project-sentiment-analysis/api/add_product.php', 
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function(response) {
            if (response.success) {
              alert('Product added successfully.');
              $('#addProductForm')[0].reset();
              $('#image-preview').hide(); 
              $('#preview-icon').show(); 
              $('#upload-text').show();
            } else {
              alert('Failed to add product. Please try again.');
            }
          },
          error: function() {
            alert('An error occurred. Please try again.');
          }
        });
      });

      // Show/Hide New Category Input
      $('#category').on('change', function() {
        if ($(this).val() === 'add_new') {
          $('#newCategoryWrapper').show();
        } else {
          $('#newCategoryWrapper').hide();
        }
      });
    });
  </script>
</body>
</html>
