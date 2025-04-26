<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sentimo — Add Products</title>
  <link rel="stylesheet" href="/project-sentiment-analysis/assets/styles.css?v=2">
</head>
<body>
  <nav class="navbar">
    <div class="logo">
        <a href="dashboard.php" class="logo">
            <img src="/project-sentiment-analysis/assets/logo-icon.png" alt="Sentimo icon">
            <img src="/project-sentiment-analysis/assets/logo-text.png" alt="Sentimo text">
        </a>
    </div>
    <ul class="nav-links">
      <li><a href="add_products.php">Add Product</a></li>
      <li><a href="manage_users.php">Manage Users</a></li>
      <li><a href="/project-sentiment-analysis/index.php">Logout</a></li>
    </ul>
  </nav>

  <main class="addProduct-page">

    <!-- 1) hero GIF -->
    <section class="hero">
      <img src="/project-sentiment-analysis/assets/add-product-gif.gif" alt="Sentimo Add Product">
    </section>

    <!-- 2) Add Product Form -->
  <section class="addProduct-wrapper">
    <div class="addProduct-card">
      <h2>Add Product Form</h2>
      <p class="subhead">Add a new product</p>
      <form action="add_product.php" method="POST" enctype="multipart/form-data">
        <input
          type="text"
          name="product_name"
          placeholder="Product Name"
          required
        >
        <input
          type="text"
          name="price"
          placeholder="Price"
          required
        >

        <input
          type="text"
          name="category"
          placeholder="Category (e.g., Electronics, Fashion)"
          required
        >

        <label for="image-upload" class="upload-box">
          <img src="/project-sentiment-analysis/assets/upload-image-icon.png" alt="Upload Icon">
          <span>Upload Image<br><small>in .png format</small></span>
          <input
            type="file"
            id="image-upload"
            name="product_image"
            accept=".png"
            hidden
            required
          >
        </label>

        <button type="submit">ADD PRODUCT</button>
      </form>
    </div>
  </section>
     

  </main>

  <footer class="site-footer">
    <div class="logo-small">
      <img src="/project-sentiment-analysis/assets/logo-icon.png" alt="">
      <img src="/project-sentiment-analysis/assets/logo-text.png" alt="">
    </div>
    <ul class="footer-links">
      <li><a href="/project-sentiment-analysis/about.php">About</a></li>
      <li><a href="/project-sentiment-analysis/creators.php">Creators</a></li>
    </ul>
  </footer>
</body>
</html>
