<?php
  require_once __DIR__ . '/session.php';
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
    <section class="sentiment-reports">
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
    </section>

<!-- CHART -->
<section class="chart-section my-4">
    <canvas id="sentimentChart" height="100"></canvas>
</section>

<!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<canvas id="SentReviews" style="width:100%;max-width:600px"></canvas>

<script>
  const xValues = [100,200,300,400,500,600,700,800,900,1000];

new Chart("SentReviews", {
  type: "bar",
  data: {
    labels: xValues,
    datasets: [{
      data: [860,1140,1060,1060,1070,1110,1330,2210,7830,2478],
      borderColor: "red",
      fill: false
    },{
      data: [1600,1700,1700,1900,2000,2700,4000,5000,6000,7000],
      borderColor: "green",
      fill: false
    },{
      data: [300,700,2000,5000,6000,4000,2000,1000,200,100],
      borderColor: "blue",
      fill: false
    }]
  },
  options: {
    legend: {display: false}
  }
});
</script>

<!-- 
<script>
fetch('analyze_reviews.php')
    .then(response => response.json())
    .then(data => {
        const ctx = document.getElementById('sentimentChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Total Reviews', 'Positive', 'Negative', 'Neutral'],
                datasets: [{
                    label: 'Sentiment Results',
                    data: [data.total, data.positive, data.negative, data.neutral],
                    backgroundColor: [
                        'rgba(0, 0, 0, 0.6)',  // Total - Black
                        'rgba(75, 192, 192, 0.6)',  // Positive - Green
                        'rgba(255, 99, 132, 0.6)',  // Negative - Red
                        'rgba(0, 83, 248, 0.6)'  // Neutral - Blue
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(201, 203, 207, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: 'Sentiment Analysis Overview'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    });
</script> -->

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
            <th style="width: 275px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Superstar II Shoes</td>
            <td>Fashion</td>
            <td>₱5,500</td>
            <td>
              <button class="btn btn-primary btn-sm">Edit</button> <!-- Redirect to edit_product.php (it should automatically populate the product's name, categ, etc.) -->
              <button class="btn btn-danger btn-sm">Delete</button>
              <a href="view_reviews.php?product_id=<?php echo $product['id']; ?>" class="btn btn-info btn-sm">View Reviews</a>
            </td>
          </tr>
          <tr>
            <td>2</td>
            <td>Smartphone X</td>
            <td>Electronics</td>
            <td>₱25,000</td>
            <td>
              <button class="btn btn-primary btn-sm">Edit</button> <!-- Redirect to edit_product.php (it should automatically populate the product's name, categ, etc.) -->
              <button class="btn btn-danger btn-sm">Delete</button>
              <a href="view_reviews.php?product_id=<?php echo $product['id']; ?>" class="btn btn-info btn-sm">View Reviews</a>
            </td>
          </tr>
        </tbody>
      </table>
    </section>

    <!-- 4) Product Reviews Table -->
    <h2>Product Reviews</h2>
    <section class="reviews-table" style="width: 100%; overflow-x: auto;">
      <table id="reviewsTable" class="table table-striped table-bordered" style="width: 100%; table-layout: fixed;">
        <thead>
          <tr>
            <th>Product</th>
            <th>User</th>
            <th style="width: 130px;">Rating</th>
            <th style="width: 300px;">Review</th>
            <th>Sentiment</th>
            <th>Timelog</th>
            <th>Discard</th>
          </tr>
        </thead>
        <tbody>
          <!-- Reviews will be dynamically populated here -->
          <tr>
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
          </tr>
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

      // Initialize DataTables for Product Reviews Table
      $('#reviewsTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        lengthChange: true,
        pageLength: 10,
        autoWidth: false,
      });

      // Fetch and populate reviews on page load
      function fetchReviews() {
        $.ajax({
          url: '/project-sentiment-analysis/api/get_reviews.php', // Adjust the path to your API
          method: 'GET',
          success: function (response) {
            if (response.success) {
              const reviewsTable = $('#reviewsTable').DataTable();
              reviewsTable.clear(); // Clear existing rows
              response.reviews.forEach(function (review) {
                reviewsTable.row.add([
                  review.product_name,
                  review.user_name,
                  '★'.repeat(review.rating),
                  review.review,
                  review.sentiment,
                  review.timelog,
                  `<button class="btn btn-danger btn-sm discard-review" data-id="${review.id}">Discard</button>`,
                ]);
              });
              reviewsTable.draw(); // Redraw the table with new data
            } else {
              alert('Failed to fetch reviews.');
            }
          },
          error: function () {
            alert('An error occurred while fetching reviews.');
          },
        });
      }

      // Call fetchReviews on page load
      fetchReviews();

      // Handle Discard Review Action
      $(document).on('click', '.discard-review', function () {
        const reviewId = $(this).data('id');
        if (confirm('Are you sure you want to discard this review?')) {
          $.ajax({
            url: '/project-sentiment-analysis/api/discard_review.php', // Adjust the path to your API
            method: 'POST',
            data: { id: reviewId },
            success: function (response) {
              if (response.success) {
                alert('Review discarded successfully.');
                fetchReviews(); // Refresh the reviews table
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
    });
  </script>
</body>
</html>
