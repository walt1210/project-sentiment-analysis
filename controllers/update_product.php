<?php
require_once __DIR__ . "/../config.php";  
require_once __DIR__ . "/../models/ProductsModel.php"; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $product_id = $_POST['id'];
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $category_id = $_POST['category'];
    $description = $_POST['description'];
    $image = null;  
    
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
        $image = $_FILES['product_image'];
        $upload_dir = __DIR__ . '/../uploads/';
        $image_name = basename($image['name']);
        $image_path = $upload_dir . $image_name;
        if (move_uploaded_file($image['tmp_name'], $image_path)) {
            // Save only the relative path for web use
            $image = 'uploads/' . $image_name;
        } else {
            $image = null;
        }
    }

    $productModel = new ProductModel();
    $success = $productModel->update($product_id, $product_name, $price, $category_id, $description, $image);

    echo json_encode(['success' => $success]);
}
?>