<?php
  require_once __DIR__ . '/session.php';

  $category_id = isset($_GET['category']) ? $_GET['category'] : null;
  $product_id = isset($_GET['product_id']) ? $_GET['product_id'] : null;

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sentimo — Submit Review</title>
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
     <h2>Review a Product</h2>
     <section class="review-wrapper">
      <div class="review-card">
        <h2>Review Form</h2>
        <p class="subhead">Write your Review</p>
        <form id="submit-review_form">
          <!-- Category Dropdown -->
          <div class="mb-3">
            <label for="categoryDropdown" class="form-label">Category</label>
            <select id="categoryDropdown" name="category" class="form-select">
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
            <input type="radio" id="star3" name="rating" value="3" checked/><label for="star3">★</label>
            <input type="radio" id="star2" name="rating" value="2"/><label for="star2">★</label>
            <input type="radio" id="star1" name="rating" value="1"/><label for="star1">★</label>
          </div>

          <!-- Review Text -->
          <div class="mb-3">
            <label for="reviewText" class="form-label">Review</label>
            <textarea id="reviewText" name="review" class="form-control" rows="6" placeholder="Write your review here..." required></textarea>
          </div>

          <!-- Submit Button -->
          <button type="submit" class="btn btn-primary">Submit Review</button>
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
      function fetchCategories(selectedCategoryID = null) {
        $.ajax({
          url: './../../controllers/get_categories.php', // Adjust the path to your API
          method: 'GET',
          dataType: 'json',
          success: function (response) {
            if (response.length > 0) {
              const categoryDropdown = $('#categoryDropdown');
              categoryDropdown.empty();
              categoryDropdown.append('<option value="" selected>All Category</option>');
              response.forEach(function (category) {
                var c_name = category.name.replace(/\b\w/g, char => char.toUpperCase())
                categoryDropdown.append(`<option value="${category.id}">${c_name}</option>`);
              
                if (selectedCategoryID) {
                  categoryDropdown.val(selectedCategoryID);
                }
              
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


      function fetchProducts(categoryID = null, productID=null) {
        
        $.ajax({
          url: './../../controllers/get_products.php', // Adjust the path to your API
          method: 'GET',
          dataType: 'json',
          success: function (response) {
            if (response.success) {
              const productDropdown = $('#productDropdown');
              productDropdown.empty();
              productDropdown.append('<option value="" disabled selected>Select Product</option>');
              response.data.forEach(function (product) {
                console.log(product.category_id, categoryID) ;

                if(!categoryID || product.category_id == categoryID){
                  var p_name = product.name.replace(/\b\w/g, char => char.toUpperCase())
                  productDropdown.append(`<option value="${product.id}" data-category_id="${product.category_id}" >${p_name}</option>`);
               
                }
                
              });
              if (productID) {
                productDropdown.val(productID);
              }
            } else {
              alert('Failed to fetch products.');
            }
          },
          error: function () {
            alert('An error occurred while fetching products.');
          },
        });
      }


      //Store data to database
      $('#submit-review_form').on('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission
        const form = $(this);
        const formData = form.serialize(); // Serialize the form data

        $.ajax({
          url: './../../controllers/submit_review_controller.php', // Adjust the path to your API
          method: 'POST',
          data: formData,
          dataType: 'json',
          success: function (response) {
            if (response.success) {
              form[0].reset();
              // fetchCategories();
              // fetchProducts();
              alert('Review submitted successfully!');
              //setTimeout(() => location.reload(), 100);
              
              window.location.href = 'submit_review.php'; // Redirect to view reviews page
            } else {
              alert('Failed to submit review.');
            }
          },
          error: function () {
            alert('An error occurred while submitting the review.');
          },
        });
      });







      fetchCategories( <?php echo json_encode($category_id); ?>);
      fetchProducts(<?php echo json_encode($category_id); ?>, <?php echo json_encode($product_id); ?>);


      // Fetch products based on the selected category
      $('#categoryDropdown').on('change', function () {
        const categoryID = $(this).val() ? $(this).val() : null;
        fetchProducts(categoryID);
      });
      
      //select category from product automatically
      $('#productDropdown').on('change', function () {
        $('#categoryDropdown').val($(this).find(':selected').data('category_id'));
      });
    
      
    });
    
  </script>
</body>
</html>
