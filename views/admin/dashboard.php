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
      <img src="../../assets/admin-dashboard-here.gif" alt="Sentimo Admin Dashboard overview">
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

<form method="post" action="../../controllers/export_reviews.php">
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

<!-- 4) Category List -->
<h2>Category List</h2>
<section class="category-table" style="width: 100%; overflow-x: auto;">
  <table id="categoryTable" class="table table-striped table-bordered" style="width: 100%; table-layout: fixed;">
    <thead>
      <tr>
        <th style="width: 100px;">ID</th>
        <th>Category Name</th>
      </tr>
    </thead>
    <tbody>
      <!-- Data will be dynamically injected here via JavaScript -->
    </tbody>
  </table>
</section>

<!-- 5) Product Reviews Table -->
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
  <script src="../../assets/js/admin-dashboard.js"></script>
</body>
</html>
