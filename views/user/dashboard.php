<?php
  // require_once __DIR__ . '/session.php';

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
  <script>
  window.addEventListener('pageshow', function (event) {
    if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
      location.reload(); // Reloads page and re-triggers PHP
    }
  });

    $(document).ready(function () {
        var ctgry = {};

        loadCategories(function() {
            loadProducts(); // Will now run *after* categories are fully loaded
        });


        //load Categories
        function loadCategories(callback) {
            $("#categoryDropdown").empty();
            $("#categoryDropdown").append($('<option>', {
                value: "all",
                text: "All Categories"
            }));

            $.getJSON("../../controllers/get_categories.php", function(result){
                $.each(result, function(index, categories) {
                    ctgry[categories.id] = categories.name;

                    $("#categoryDropdown").append($('<option>', {
                        value: categories.name,
                        text: categories.name.split(" ").map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(" "),
                        id: categories.id
                    }));

                    console.log(categories.id + ": " + categories.name);
                });

                //Categories are loaded, now call the callback
                if (typeof callback === "function") {
                    callback();
                }
            });
        }


        function loadProducts(){
            $("#productRecommendations").empty();
            var append = "";
            $.getJSON("../../controllers/get_products.php", function(result){
                $.each(result.data, function(index, products) {
                    let cat_name = ctgry[products.category_id];
                    if (typeof cat_name === "string" && cat_name.trim() !== "") {
                        cat_name = cat_name.replace(/\b\w/g, char => char.toUpperCase());
                    } else {
                        cat_name = "Unknown";
                    }
                    let prod_name = products.name.replace(/\b\w/g, char => char.toUpperCase());
                    append = `
                                 <div class="col-md-4">
                                    <div class="card">
                                    <img src="../../uploads/${products.image_url}" class="card-img-top" alt="${products.name}">
                                        <div class="card-body">
                                            <h5 class="card-title">${prod_name}</h5>
                                            <p class="card-text">Category: ${cat_name}</p>
                                            <button class="btn btn-primary view-product" data-id="${products.id}" data-name="${products.name}">View Product Reviews</button>
                                        </div>
                                    </div>
                                </div>
                    `;
                    $("#productRecommendations").append(append);
                    //console.log(products.id + ": " + products.name);
                });

            });
        }
      
        function loadProductDetails(product_id) {
            $('#modalProductImage').attr('src', '');
            $('#modalProductName').text('');
            $('#modalProductCategory').text('');
            $('#likeCount').text('');
            $('#unlikeCount').text('');

            $('#likeButton').removeData('product-id'); 
            $('#unlikeButton').removeData('product-id'); 
            $('#btnComment').removeData('href');

            return $.ajax({
                url: '../../controllers/get_one_product.php',
                method: 'GET',
                data: { "product_id": product_id },
                dataType: 'json'
            }).then(function(response) {
                if (response.success) {
                    const category = ctgry[response.data.category_id]
                        .split(" ")
                        .map(word => word.charAt(0).toUpperCase() + word.slice(1))
                        .join(" ");

                    $('#modalProductImage').attr('src', `../../uploads/${response.data.image_url}`);
                    var prod_name = response.data.name.replace(/\b\w/g, char => char.toUpperCase());
                    $('#modalProductName').text(prod_name);
                    $('#modalProductCategory').text(`Category: ${category}`);
                    $('#likeCount').text(response.data.like_count);
                    $('#unlikeCount').text(response.data.dislike_count);

                    $('#likeButton').data('product-id', product_id); 
                    $('#unlikeButton').data('product-id', product_id);
                    $('#btnComment').data('href', `submit_review.php?product_id=${product_id}&category=${response.data.category_id}`); // Set the data attribute for the button

                    //console.log($('#likeButton').data('product-id'));

                    const lk = ['like', 'dislike'];

                    // if (lk.includes(response.data.user_vote)) {
                      //console.log('Yes, banana is in the list!');
                      updateUI(response.data.user_vote);
                      console.log("vote" + response.data.user_vote);
                    // }


                    return true;
                } else {
                    alert("Product failed to load. Please try again later.");
                    return false;
                }
            }).catch(function() {
                alert("Error occurred while loading product details.");
                return false;
            });
        }

        function loadReviews(product_id) {
            $('#productComments').empty();

            return $.ajax({
                url: '../../controllers/get_reviews_of_product.php',
                method: 'GET',
                data: { "product_id": product_id },
                dataType: 'json'
            }).then(function(response) {
                if (response.success) {
                    const data = response.data;
                    let commentsHtml = '';

                    data.forEach(review => {
                        commentsHtml += `
                            <div class="mb-4">
                                <strong>${review.user_name}</strong>
                                <small class="text-muted">(${review.name})</small>
                                <p>${'⭐'.repeat(review.rating)} (${review.rating}/5)</p>
                                <p>${review.review_text}</p>
                                <hr>
                            </div>`;
                    });

                    $('#productComments').html(commentsHtml);
                    return true;
                } else {
                    alert("Product reviews failed to load. Please try again later.");
                    return false;
                }
            }).catch(function() {
                alert("Error occurred while loading reviews.");
                return false;
            });
        }

        $(document).on("click", ".view-product", function() {
            const productId = $(this).data('id');
            const productName = $(this).data('name');

            $.when(loadProductDetails(productId), loadReviews(productId)).done(function(resultA, resultB) {
                if (resultA && resultB) {
                    console.log('Both product and reviews loaded successfully');
                    $('#productReviewModal').modal('show');
                } else {
                    console.log('One or both failed to load');
                }
            });
        });

        let currentStatus = null; // 'like' or 'unlike'

        function updateUI(status) {
            currentStatus = status;
            if (status === 'like') {
              $('#likeButton').css('background-color', '#388E3C');
                $('#unlikeButton').css('background-color', '#FFAB91');
            } else if(status =="dislike") {
              $('#unlikeButton').css('background-color', '#F44336');
                $('#likeButton').css('background-color', '#81C784');
            }
            else {
                $('#likeButton').css('background-color', '#81C784');
                $('#unlikeButton').css('background-color', '#FFAB91');
            }
        }

        //function for if the user has liked or disliked the product, show on load of modal tapos na
        function updateProductVote(vote, product_ID){
          $.ajax({
            url: '../../controllers/product_vote_controller.php',  // your backend URL
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                product_id: product_ID,      // Example data
                user_vote: vote
            }),
            success: function(response) {
                console.log('Server response:', response.msg);
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', error);
            }
        });
        }

        //function for every click of like or dislike button 

          $('.reaction-btn').on('click', function() {
            //if like button is clicked, update the product vote to like
            // and update the UI accordingly
            if ($(this).attr('id') == 'likeButton') {
              $(this).data('product-id');
              updateProductVote('like', $(this).data('product-id'));
              updateUI('like');
            } 
            //If unlike button is clicked, update the product vote to dislike
            // and update the UI accordingly
            else if ($(this).attr('id') == 'unlikeButton') {
              updateProductVote('dislike', $(this).data('product-id'));
              updateUI('dislike');
            }
          });



          $('#btnComment').on('click', function() {
            let url = $(this).data('href');
            window.location.href = url;
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