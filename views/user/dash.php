<?php
  require_once __DIR__ . '/session.php';

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
                <!-- Categories will be dynamically populated here added by the super admin -->
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
            <!-- Sample Product Cards -->
            <div class="col-md-4">
                <div class="card">
                <img src="../../uploads/superstar-shoes.png" class="card-img-top" alt="Superstar II Shoes">
                    <div class="card-body">
                        <h5 class="card-title">Superstar II Shoes</h5>
                        <p class="card-text">Category: Fashion</p>
                        <button class="btn btn-primary view-product" data-id="21" data-name="Superstar II Shoes">View Product Reviews</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                <img src="../../uploads/smartphone-x.png" class="card-img-top" alt="Smartphone X">
                    <div class="card-body">
                        <h5 class="card-title">Smartphone X</h5>
                        <p class="card-text">Category: Electronics</p>
                        <button class="btn btn-primary view-product" data-id="22" data-name="Smartphone X">View Product Reviews</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                <img src="../../uploads/gaming-laptop.png" class="card-img-top" alt="Gaming Laptop Pro">
                    <div class="card-body">
                        <h5 class="card-title">Gaming Laptop Pro</h5>
                        <p class="card-text">Category: Computers</p>
                        <button class="btn btn-primary view-product" data-id="23" data-name="Gaming Laptop Pro">View Product Reviews</button>
                    </div>
                </div>
            </div>
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
                <button id="likeButton" class="btn btn-success btn-sm me-2">
                  👍 Like <span id="likeCount" class="badge bg-light text-dark">0</span>
                </button>
                <button id="unlikeButton" class="btn btn-danger btn-sm me-2">
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
            <div class="mb-4">
              <strong>Taylor Swift</strong>
              <small class="text-muted">(2025-04-17 12:34:56)</small>
              <p>⭐⭐⭐⭐⭐ (5/5)</p>
              <p>Great product! Very comfortable and stylish.</p>
              <hr>
              <!-- <td>
                <a href="edit_review.php?id=<?php //echo $review['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                <button class="btn btn-sm btn-danger delete-review" data-id="<?php //echo $review['id']; ?>">Delete</button>
              </td> -->
            </div>
            <div class="mb-4">
              <strong>Kali Uchis</strong>
              <small class="text-muted">(2025-04-16 10:20:30)</small>
              <p>⭐⭐⭐⭐ (4/5)</small>
              <p>Good value for money, but the battery life could be better.</p>
              <hr>
              <!-- <td>
                <a href="edit_review.php?id=<?php //echo $review['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                <button class="btn btn-sm btn-danger delete-review" data-id="<?php //echo $review['id']; ?>">Delete</button>
              </td> -->
            </div>
            <div class="mb-4">
              <strong>Sabrina Carpenter</strong>
              <small class="text-muted">(2025-04-15 15:45:10)</small>
              <p>⭐⭐⭐ (3/5)</small>
              <p>Performance is decent, but it overheats during long gaming sessions.</p>
              <hr>
              <!-- <td>
                <a href="edit_review.php?id=<?php //echo $review['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                <button class="btn btn-sm btn-danger delete-review" data-id="<?php //echo $review['id']; ?>">Delete</button>
              </td> -->
            </div>
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
            //$("#productRecommendations").empty();
            var append = "";
            $.getJSON("../../controllers/get_products.php", function(result){
                $.each(result.data, function(index, products) {
                    let cat_name = ctgry[products.category_id];
                    if (typeof cat_name === "string" && cat_name.trim() !== "") {
                        cat_name = cat_name.replace(/\b\w/g, char => char.toUpperCase());
                    } else {
                        cat_name = "Unknown";
                    }
                    //cat_name = cat_name.split(" ").map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(" ");
                    //cat_name = String(cat_name);
                    append = `
                                 <div class="col-md-4">
                                    <div class="card">
                                    <img src="${products.image_url}" class="card-img-top" alt="${products.name}">
                                        <div class="card-body">
                                            <h5 class="card-title">${products.name}</h5>
                                            <p class="card-text">Category: ${cat_name}</p>
                                            <button class="btn btn-primary view-product" data-id="${products.id}" data-name="${products.name}">View Product Reviews</button>
                                        </div>
                                    </div>
                                </div>
                    `;
                    $("#productRecommendations").append(append);
                    console.log(products.id + ": " + products.name);
                });

            });
        }
      
        function loadProductDetails(product_id) {
            $('#modalProductImage').attr('src', '');
            $('#modalProductName').text('');
            $('#modalProductCategory').text('');
            $('#likeCount').text('');
            $('#unlikeCount').text('');

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

                    $('#modalProductImage').attr('src', response.data.image_url);
                    $('#modalProductName').text(response.data.name);
                    $('#modalProductCategory').text(`Category: ${category}`);
                    $('#likeCount').text(response.data.like_count);
                    $('#unlikeCount').text(response.data.dislike_count);
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



        
      // Handle "View Product" button click
    //   $(".view-product").on('click', function () {
    //     const productId = $(this).data('id');
    //     const productName = $(this).data('name');

        // Fetch product details and reviews via AJAX
        // $.ajax({
        //   url: '/project-sentiment-analysis/api/get_product_reviews.php', // Adjust the path to your API
        //   method: 'GET',
        //   data: { product_id: productId },
        //   success: function (response) {
        //     if (response.success) {
        //       // Populate product details
        //       $('#modalProductImage').attr('src', response.product.image);
        //       $('#modalProductName').text(response.product.name);
        //       $('#modalProductCategory').text(`Category: ${response.product.category}`);
        //       $('#likeCount').text(response.product.likes);
        //       $('#unlikeCount').text(response.product.unlikes);

        //       // Populate user reviews
        //       let commentsHtml = '';
        //       response.reviews.forEach(review => {
        //         commentsHtml += `
        //           <div class="mb-4">
        //             <strong>${review.user_name}</strong>
        //             <small class="text-muted">(${review.timelog})</small>
        //             <p>${'⭐'.repeat(review.rating)} (${review.rating}/5)</p>
        //             <p>${review.comment}</p>
        //             <hr>
        //           </div>`;
        //       });
        //       $('#productComments').html(commentsHtml);
        //     } else {
        //       $('#productComments').html('<p class="text-danger">Failed to load reviews. Please try again later.</p>');
        //     }
        //   },
        //   error: function () {
        //     $('#productComments').html('<p class="text-danger">An error occurred. Please try again later.</p>');
        //   }
        // });

        // Show the modal
    //     $('#productReviewModal').modal('show');
    //   });








      // Handle Like Button Click
    //   $('#likeButton').on('click', function () {
    //     const productId = $('#modalProductName').data('id');
    //     $.ajax({
    //       url: '/project-sentiment-analysis/api/like_product.php', // Adjust the path to your API
    //       method: 'POST',
    //       data: { product_id: productId },
    //       success: function (response) {
    //         if (response.success) {
    //           $('#likeCount').text(response.likes);
    //         } else {
    //           alert('Failed to like the product. Please try again.');
    //         }
    //       },
    //       error: function () {
    //         alert('An error occurred. Please try again.');
    //       }
    //     });
    //   });







      // Handle Unlike Button Click
    //   $('#unlikeButton').on('click', function () {
    //     const productId = $('#modalProductName').data('id');
    //     $.ajax({
    //       url: '/project-sentiment-analysis/api/unlike_product.php', // Adjust the path to your API
    //       method: 'POST',
    //       data: { product_id: productId },
    //       success: function (response) {
    //         if (response.success) {
    //           $('#unlikeCount').text(response.unlikes);
    //         } else {
    //           alert('Failed to unlike the product. Please try again.');
    //         }
    //       },
    //       error: function () {
    //         alert('An error occurred. Please try again.');
    //       }
    //     });
    //   });





      // Handle comment submission
    //   $('#addCommentForm').on('submit', function(e) {
    //     e.preventDefault();
    //     const commentData = {
    //       product_id: $('#modalProductName').data('id'),
    //       comment: $('#commentText').val()
    //     };

        // Submit the comment via AJAX
        // $.ajax({
        //   url: '/project-sentiment-analysis/api/add_product_comment.php', // Backend endpoint to add a comment
        //   method: 'POST',
        //   data: commentData,
        //   success: function(response) {
        //     if (response.success) {
        //       alert('Comment added successfully!');
        //       $('#commentText').val(''); 
        //       $('#productComments').append(`
        //         <div class="mb-3">
        //           <strong>You</strong>
        //           <p><strong>Rating:</strong> ⭐⭐⭐⭐⭐ (5/5)</p>
        //           <p><strong>Review:</strong> ${commentData.comment}</p>
        //           <p><strong>Sentiment:</strong> Positive</p>
        //           <small class="text-muted">Just now</small>
        //         </div>
        //         <hr>`);
        //     } else {
        //       alert('Failed to add comment. Please try again.');
        //     }
        //   },
        //   error: function() {
        //     alert('An error occurred. Please try again.');
        //   }
        // });
    //   });







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

<?php
// require_once '../../db_connection.php'; // Adjust the path to your DB connection file

// header('Content-Type: application/json');

// if (isset($_GET['product_id'])) {
//     $productId = intval($_GET['product_id']);

//     // Fetch product details
//     $productQuery = "SELECT name, category, image, likes, unlikes FROM products WHERE id = ?";
//     $stmt = $conn->prepare($productQuery);
//     $stmt->bind_param("i", $productId);
//     $stmt->execute();
//     $productResult = $stmt->get_result();

//     if ($productResult->num_rows > 0) {
//         $product = $productResult->fetch_assoc();

//         // Fetch product reviews
//         $reviewsQuery = "SELECT u.name AS user_name, r.timelog, r.rating, r.comment, r.id
//                          FROM reviews r
//                          JOIN users u ON r.user_id = u.id
//                          WHERE r.product_id = ?";
//         $stmt = $conn->prepare($reviewsQuery);
//         $stmt->bind_param("i", $productId);
//         $stmt->execute();
//         $reviewsResult = $stmt->get_result();

//         $reviews = [];
//         while ($row = $reviewsResult->fetch_assoc()) {
//             $reviews[] = $row;
//         }

//         echo json_encode([
//             'success' => true,
//             'product' => $product,
//             'reviews' => $reviews
//         ]);
//     } else {
//         echo json_encode(['success' => false, 'message' => 'Product not found.']);
//     }
// } else {
//     echo json_encode(['success' => false, 'message' => 'Invalid product ID.']);
// }
?>