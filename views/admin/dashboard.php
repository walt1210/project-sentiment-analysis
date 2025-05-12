<?php
  require_once __DIR__ . '/session.php';
  require_once __DIR__ . '/../../models/ProductReviewModel.php';
  $PRModel = new ProductReviewModel();
  $OverallSentiment = $PRModel->getTotalReviewsSentimentPercentage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sentimo — Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/styles.css?v=2">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
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

    <!-- 1) hero GIF -->
    <section class="hero">
      <img src="/project-sentiment-analysis/assets/admin-dashboard-here.gif" alt="Sentimo Admin Dashboard overview">
    </section>

  <main class="dashboard-page">
    <!-- 2) sentiment -->
    <h2>Sentiment Report</h2>
    <!-- <section class="sentiment-reports">
        <div class="sentiment-card">
        <h3>125</h3>
        <p>Total Reviews</p>
    </div>
    <div class="sentiment-card">
        <h3>60%</h3>
        <p>Positive</p>
    </div>
    <div class="sentiment-card">
        <h3>25%</h3>
        <p>Negative</p>
    </div>
    <div class="sentiment-card">
        <h3>15%</h3>
        <p>Neutral</p>
    </div>
    </section> -->

<section class="sentiment-reports">
    <?php
      $total_reviews = 0;
      $positive_percentage = 0;
      $negative_percentage = 0;
      $neutral_percentage = 0;
    if(!empty($OverallSentiment)){
      foreach($OverallSentiment as $sentiment){
        $total_reviews += $sentiment['total_reviews'];
        if($sentiment['type'] == 'positive'){
            $positive_percentage = $sentiment['percentage'];
        } elseif($sentiment['type'] == 'negative'){
            $negative_percentage = $sentiment['percentage'];
        } elseif($sentiment['type'] == 'neutral'){
            $neutral_percentage = $sentiment['percentage'];
        }
      }
    }
    ?>

    <div class="sentiment-card">
        <h3><?php echo $total_reviews; ?></h3>
        <p>Total Reviews</p>
    </div>
    <div class="sentiment-card">
        <h3><?php echo $positive_percentage; ?>%</h3>
        <p>Positive</p>
    </div>
    <div class="sentiment-card">
        <h3><?php echo $negative_percentage; ?>%</h3>
        <p>Negative</p>
    </div>
    <div class="sentiment-card">
        <h3><?php echo $neutral_percentage; ?>%</h3>
        <p>Neutral</p>
    </div>
</section>

<!-- CHART -->
<?php 
// $chartData = [
//     [
//         'product' => 'Shoes',
//         'positive' => 60,
//         'negative' => 25,
//         'neutral' => 15
//     ],
//     [
//         'product' => 'Smartphone',
//         'positive' => 40,
//         'negative' => 35,
//         'neutral' => 25
//     ],
//     [
//         'product' => 'Pants',
//         'positive' => 80,
//         'negative' => 10,
//         'neutral' => 10
//     ]
// ];
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stacked Sentiment Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <section class="sentiment-chart">
        <h2 style="text-align: center;">Product Sentiment Breakdown</h2>
        <canvas id="sentimentChart" width="700" height="400"></canvas>

        <!-- <script>
            const labels = <?php //echo json_encode(array_column($chartData, 'product')); ?>;
            const positiveData = <?php //echo json_encode(array_column($chartData, 'positive')); ?>;
            const negativeData = <?php //echo json_encode(array_column($chartData, 'negative')); ?>;
            const neutralData = <?php //echo json_encode(array_column($chartData, 'neutral')); ?>;

            const ctx = document.getElementById('sentimentChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                          {
                              label: 'Positive',
                              data: positiveData,
                              backgroundColor: '#64b5f6', // light blue
                              stack: 'sentiments'
                          },
                          {
                              label: 'Negative',
                              data: negativeData,
                              backgroundColor: '#5c6bc0', // blue-gray
                              stack: 'sentiments'
                          },
                          {
                              label: 'Neutral',
                              data: neutralData,
                              backgroundColor: '#283593', // dark navy
                              stack: 'sentiments'
                          }
                      ]

                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.dataset.label}: ${context.raw}%`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            stacked: true
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true,
                            max: 100,
                            title: {
                                display: true,
                                text: 'Percentage'
                            }
                        }
                    }
                }
            });
        </script> -->
    </section>
</body>
</html>

</section> 

<form method="post" action="/project-sentiment-analysis/controllers/export_reviews.php">
    <button type="submit" name="export" class="btn btn-primary">Export Reviews to CSV</button>
</form>


<!-- 3) Products Table -->
<h2>Product List</h2>
<section class="product-table" style="width: 100%; overflow-x: auto;">
  <table id="productTable" class="table table-striped table-bordered" style="width: 100%; table-layout: fixed;">
    <thead>
      <tr>
        <th style="width: 100px;">ID</th>
        <th>Product Name</th>
        <th>Category</th>
        <th>Price</th>
        <th>Image</th>
        <th style="width: 275px;">Actions</th>
      </tr>
    </thead>
    <tbody>
      <!-- Data will be injected here via jQuery -->
    </tbody>
  </table>
</section>

</script>           
        
    <!-- 4) Product Reviews Table -->
    <h2>Product Reviews</h2>
    <section class="reviews-table" style="width: 100%; overflow-x: auto;">
      <table id="reviewsTable" class="table table-striped table-bordered" style="width: 100%; table-layout: auto;">
        <thead>
          <tr>
            <th>Product</th>
            <th>Category</th>
            <th>User</th>
            <th>Rating</th>
            <th style="width: 40%;">Review</th> <!-- Set a wider width for the Review column -->
            <th>Sentiment</th>
          </tr>
        </thead>
        <tbody>
          <!-- Reviews will be dynamically populated here -->
          <!-- <tr>
            <td>Superstar II Shoes</td>
            <td>Taylor Swift</td>
            <td>⭐⭐⭐⭐⭐</td>
            <td>Great product! Very comfortable.</td>
            <td>Positive</td>
            <td>2025-04-17 12:34:56</td>
            <td><button class="btn btn-danger btn-sm discard-review" data-id="1">Discard</button></td>
          </tr>
          <tr>
            <td>Smartphone X</td>
            <td>Kali Uchis</td>
            <td>⭐⭐⭐</td>
            <td>Good performance but battery life could be better.</td>
            <td>Neutral</td>
            <td>2025-04-16 10:20:30</td>
            <td><button class="btn btn-danger btn-sm discard-review" data-id="2">Discard</button></td>
          </tr>
          <tr>
            <td>Ultra Stretch Pants</td>
            <td>Sabrina Carpenter</td>
            <td>⭐⭐⭐⭐⭐</td>
            <td>Perfect fit and very durable.</td>
            <td>Positive</td>
            <td>2025-04-15 15:45:10</td>
            <td><button class="btn btn-danger btn-sm discard-review" data-id="3">Discard</button></td> 
          </tr> -->
        </tbody>
      </table>
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
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

  <script>
    window.addEventListener('pageshow', function (event) {
    if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
      location.reload(); 
    }
  });
    $(document).ready(function () {
      // Initialize DataTables for Product List Table
      $('#productTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        lengthChange: true,
        pageLength: 10,
        autoWidth: false,
      });

  function fetchProducts() {
  $.ajax({
    url: './../../controllers/get_products.php',
    method: 'GET',
    dataType: 'json',
    success: function (response) {
      console.log(response); // Log the response to check the structure
      if (response.success) {
        const productsTable = $('#productTable').DataTable();
        productsTable.clear();
        response.data.forEach(function (product) {
          const productName = product.name ? product.name.replace(/\b\w/g, char => char.toUpperCase()) : '';
          const categoryName = product.category_id ? product.category_id.replace(/\b\w/g, char => char.toUpperCase()) : '';
          const price = product.price ? `₱${parseFloat(product.price).toFixed(2)}` : '₱0.00';
          const image = product.image_url ? `<img src='/project-sentiment-analysis/${product.image_url}' width='60'>` : '';
            // const image = product.image ? `<img src='../../uploads/${product.image}' width='60'>` : '';
          const actions = `
            <a href='edit_product.php?id=${product.id}' class='btn btn-sm btn-primary'>Edit</a>
            <button class='btn btn-sm btn-danger delete-btn' data-id='${product.id}'>Delete</button>
          `;

          productsTable.row.add([ 
            product.id,
            productName,
            categoryName,
            price,
            image,
            actions
          ]);
        });
        productsTable.draw();
      } else {
        alert('Failed to fetch products.');
      }
    },
    error: function () {
      alert('An error occurred while fetching products.');
    },
  });
}

fetchProducts();

$(document).on('click', '.delete-btn', function () {
  const productId = $(this).data('id');
  console.log("Product ID to delete: ", productId);  // Log productId to check
  
  if (confirm('Are you sure you want to delete this product?')) {
    $.ajax({
      url: '/project-sentiment-analysis/views/admin/delete_product.php',
      method: 'GET',
      data: { id: productId },
      success: function(response) {
        console.log(response);  
        
        try {
          response = JSON.parse(response);  
        } catch (error) {
          console.error('Failed to parse JSON response:', error);
        }
        
        if (response.success) {
          alert('Product deleted successfully.');
          location.reload(true);  
        } else {
          alert('Failed to delete the product. ' + (response.message || ''));
        }
      },
      error: function() {
        alert('An error occurred while deleting the product.');
      },
    });
  }
});


function deleteProduct(productId) {
  $.ajax({
    url: '/project-sentiment-analysis/views/admin/delete_product.php',  // Ensure this is the correct URL
    method: 'GET',
    data: { id: productId },
    success: function (response) {
      if (response.success) {
        alert('Product deleted successfully.');
        location.reload();
      } else {
        alert('Failed to delete the product.');
      }
    },
    error: function () {
      alert('An error occurred while deleting the product.');
    },
  });
}

      // Initialize DataTables for Product Reviews Table
      $('#reviewsTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        lengthChange: true,
        pageLength: 10,
        autoWidth: false,
      });

      function fetchReviews() {
        $.ajax({
          // url: '/project-sentiment-analysis/api/get_reviews.php',
          url: './../../controllers/get_all_reviews.php', 
          method: 'GET',
          dataType: 'json',
          success: function (response) {
            if (response.success) {
              const reviewsTable = $('#reviewsTable').DataTable();
              reviewsTable.clear(); 
              response.data.forEach(function (review) {
                reviewsTable.row.add([
                  review.product_name.replace(/\b\w/g, char => char.toUpperCase()),
                  review.category_name.replace(/\b\w/g, char => char.toUpperCase()),
                  review.email,
                  '★'.repeat(review.rating),
                  review.review_text,
                  review.type.replace(/\b\w/g, char => char.toUpperCase())
                ]);
              });
              reviewsTable.draw(); 
            } else {
              alert('Failed to fetch reviews.');
            }
          },
          error: function () {
            alert('An error occurred while fetching reviews.');
          },
        });
      }

      fetchReviews();

      $(document).on('click', '.discard-review', function () {
        const reviewId = $(this).data('id');
        if (confirm('Are you sure you want to discard this review?')) {
          $.ajax({
            url: '/project-sentiment-analysis/api/discard_review.php', 
            method: 'POST',
            data: { id: reviewId },
            success: function (response) {
              if (response.success) {
                alert('Review discarded successfully.');
                fetchReviews(); 
              } else {
                alert('Failed to discard review.');
              }
            },
            error: function () {
              alert('An error occurred while discarding the review.');
            },
          });
        }
      });

      $.ajax({
        url: './../../controllers/get_product_with_total_sentiment.php',
        method: 'GET',
        dataType: 'json',
        success: function (response) {
          let labels = [];
          let positive = [];
          let neutral = [];
          let negative = [];

          response.data.forEach(function (item) {
            labels.push(item.product);
            positive.push(parseInt(item.positive));
            neutral.push(parseInt(item.neutral));
            negative.push(parseInt(item.negative));
          });

          const ctx = document.getElementById('sentimentChart').getContext('2d');

          new Chart(ctx, {
            type: 'bar',
            data: {
              labels: labels,
              datasets: [
                {
                  label: 'Positive',
                  data: positive,
                  backgroundColor: 'rgba(100, 181, 246, 0.7)'
                },
                {
                  label: 'Neutral',
                  data: neutral,
                  backgroundColor: 'rgba(92, 107, 192, 0.7)'
                },
                {
                  label: 'Negative',
                  data: negative,
                  backgroundColor: 'rgba(40, 53, 147, 0.7)'
                }
              ]
            },
            options: {
              responsive: true,
              plugins: {
                tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return `${context.dataset.label}: ${context.raw}%`;
                                }
                            }
                        },
                title: {
                  display: true,
                  text: 'Sentiment Breakdown by Product'
                }
              },
              scales: {
                x: { stacked: true },
                y: { stacked: true, beginAtZero: true,  max: 100,
                            title: {
                                display: true,
                                text: 'Percentage'
                            }
                }
              }
            }
          });
        },
        error: function (xhr, status, error) {
          console.error('AJAX Error: ' + status + error);
        }
      });

    });
  </script>
</body>
</html>
