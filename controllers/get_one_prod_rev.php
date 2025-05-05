<?php
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    require_once __DIR__ . '/../models/ProductReviewModel.php';
    
    $PRModel = new ProductReviewModel();
    $product_review_id = $_GET['id'];
    $data = $PRModel->getOneByID($product_review_id);
    if(!empty($data)){
        echo json_encode( ['success' => true, 'review' => $data, 'message' => "Review retrieved."] );
    }
    else{
        echo json_encode( ['success' => false, 'message' => 'No review found'] );
    } 
}
?>