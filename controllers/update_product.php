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
    $imageFile = $_FILES['product_image'];
    $uploadDir = __DIR__ . '/../uploads/';
    $imageName = uniqid() . '_' . basename($imageFile['name']);
    $imagePath = $uploadDir . $imageName;

    if (move_uploaded_file($imageFile['tmp_name'], $imagePath)) {
        $image = 'uploads/' . $imageName;
    } else {
        $image = null;
    }
}


    $productModel = new ProductModel();
    $success = $productModel->update($product_id, $product_name, $price, $category_id, $description, $image);

    echo json_encode(['success' => $success]);
}
?>