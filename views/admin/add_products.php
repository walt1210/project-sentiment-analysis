<?php
  require_once __DIR__ . '/session.php';
  require_once __DIR__ . '/../../config.php';
  $conn = Database::connect();

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response = [];

    if (
        isset($_POST['product_name'], $_POST['price'], $_POST['category'], $_POST['product_description']) &&
        isset($_FILES['product_image']) && $_FILES['product_image']['error'] === 0
    ) {
        $productName = $_POST['product_name'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $description = $_POST['product_description'];

        $image = $_FILES['product_image'];
        $imageName = basename($image['name']);
        $imageURL = '/uploads/' . $imageName;

        if (move_uploaded_file($image['tmp_name'], '../../uploads/' . $imageName)) {

            $stmt = $conn->prepare("INSERT INTO products (name, price, category_id, description, image_url) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sdiss", $productName, $price, $category, $description, $imageURL);

            if ($stmt->execute()) {
                $response['success'] = true;
            } else {
                $response['success'] = false;
                $response['error'] = 'DB insert failed';
            }

            $stmt->close();
            $conn->close();
        } else {
            $response['success'] = false;
            $response['error'] = 'Image upload failed';
        }
    } else {
        $response['success'] = false;
        $response['error'] = 'Invalid input';
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sentimo — Add Products</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
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

    <!-- 1) Hero GIF -->
    <section class="hero">
      <img src="../../assets/add-product-gif.gif" alt="Sentimo Add Product">
    </section>

    <!-- 2) Add Product Form -->
    <section class="addProduct-wrapper">
      <div class="addProduct-card">
        <h2>Add Product Form</h2>
        <p class="subhead">Add a new product</p>
        <form id="addProductForm" enctype="multipart/form-data">
          <input type="text" name="product_name" placeholder="Product Name" required>
          <input type="text" name="price" placeholder="Price" required>
          <!-- Category Dropdown -->
          <div class="form-group">
            <select id="category" name="category" class="form-control" required>
              <option value="">Select Category</option>
              <option value="others">Others</option>
            </select>
          </div>
          <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"  name="product_description" placeholder="Product Description" required></textarea>
          <label for="image-upload" class="upload-box">
            <img src="../../assets/upload-image-icon.png" alt="Upload Icon" id="preview-icon">
            <span id="upload-text">Upload Image<br><small>in .png format</small></span>
            <input type="file" id="image-upload" name="product_image" accept=".png" hidden required>
          </label>
          <img id="image-preview" src="#" alt="Image Preview" style="display: none; max-width: 100%; margin-top: 10px;">
          <button type="submit" class="btn btn-primary">ADD PRODUCT</button>
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
  <script src="../../assets/js/add-products.js"></script>
</body>
</html>
