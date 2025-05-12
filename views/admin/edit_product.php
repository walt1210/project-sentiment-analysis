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
          <li class="nav-item"><a class="nav-link" href="add_categories.php">Add Categories</a></li>
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
          
          <!-- Description -->
          <input type="text" id="description" name="description" placeholder="Description" required>

          <!-- Image Upload -->
          <label for="image-upload" class="upload-box">
            <img src="../../uploads/" alt="Upload Icon" id="preview-icon">
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

   function fetchProductDetails(productId) {
  $.ajax({
    url: './../../controllers/get_products.php',
    method: 'GET',
    dataType: 'json', 
    data: { id: productId },
    success: function (response) {
      console.log(response); 

      if (response.success && Array.isArray(response.data)) {
        const product = response.data.find(p => p.id == productId);
        if (product) {
          $('#product_name').val(product.name);
          $('#price').val(product.price);
          $('#category').val(product.category_id);
          $('#description').val(product.description);

          if (product.image_url) {
            $('#image-preview').attr('src', '../../uploads/' + product.image_url).show();
            $('#preview-icon').hide();
            $('#upload-text').hide();
          }
        } else {
          alert('Product not found.');
        }
      } else {
        alert('Failed to fetch product details.');
      }
    },
    error: function () {
      alert('An error occurred while fetching product details.');
    }
  });
}

      function fetchCategories() {
   $.ajax({
     url: './../../controllers/get_categories.php',
     method: 'GET',
     dataType: 'json',
     success: function (response) {
       console.log(response);  
       if (response.length > 0) {
         const categoryDropdown = $('#category');
         categoryDropdown.empty();
         response.forEach(function (category) {
           var c_name = category.name.replace(/\b\w/g, char => char.toUpperCase());  
           categoryDropdown.append(`<option value="${category.id}">${c_name}</option>`);
         });
       } else {
         alert('No categories found.');
       }
     },
     error: function () {
       alert('An error occurred while fetching categories.');
     },
   });
}

      const urlParams = new URLSearchParams(window.location.search);
      const productId = urlParams.get('id');

      if (productId) {
        fetchProductDetails(productId); 
        fetchCategories(); 
      } else {
        alert('No product ID provided.');
      }

      $('#editProductForm').on('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('id', productId); 

        $.ajax({
          url: '../../controllers/update_product.php', 
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          success: function (response) {
  let jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;

  console.log(jsonResponse);

  if (jsonResponse.success) {
    alert('Product updated successfully.');
    window.location.href = 'dashboard.php'; 
  } else {
    alert('Failed to update product. Please try again.');
  }
}

        });
      });
  
  </script>
</body>
</html>