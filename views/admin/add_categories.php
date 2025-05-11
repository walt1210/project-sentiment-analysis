<?php
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/../../config.php';

$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category_name'])) {
    $categoryName = trim($_POST['category_name']);
    if ($categoryName !== "") {
        $conn = Database::connect();
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        if ($stmt->execute([$categoryName])) {
            $message = "Category added successfully!";
        } else {
            $message = "Failed to add category.";
        }
    } else {
        $message = "Category name cannot be empty.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sentimo — Add Categories</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../assets/styles.css?v=2">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="../../assets/category-list.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">
      <img src="../../assets/logo-icon.png" height="50" alt="Sentimo icon">
      <img src="../../assets/logo-text.png" height="50" alt="Sentimo text">
    </a>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item"><a class="nav-link" href="add_products.php">Add Product</a></li>
      <li class="nav-item"><a class="nav-link active" href="add_categories.php">Add Categories</a></li>
      <li class="nav-item"><a class="nav-link" href="view_users.php">View Users</a></li>
      <li class="nav-item"><a class="nav-link" href="../../logoutController.php" onclick="return confirm('Are you sure you want to logout?')">Logout</a></li>
    </ul>
  </div>
</nav>

<div class="container mt-4">
  <div class="text-center mb-4">
    <h2 class="display-4 text-primary">Manage Categories</h2>
    <p class="lead text-muted">Add new categories to the system.</p>
  </div>

  <div class="form-container mx-auto mb-4" style="max-width: 500px;">
    <h4 class="text-center mb-3">Add Category</h4>

    <?php if ($message): ?>
      <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" action="add_categories.php">
      <div class="mb-3">
        <label for="category_name" class="form-label">Category Name</label>
        <input type="text" id="category_name" name="category_name" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Add Category</button>
    </form>

    <hr class="my-4">

    <h5 class="text-center">Existing Categories</h5>
    <ul id="category-list" class="list-group">
     
    </ul>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
