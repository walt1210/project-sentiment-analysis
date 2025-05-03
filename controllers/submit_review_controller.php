<?php
require_once __DIR__ ."/../config.php";
require_once __DIR__ ."/../models/ProductReviewModel.php";

if(($_SERVER['REQUEST_METHOD'] == 'POST')){
    session_start();
    $conn = Database::connect();
    $PRModel = new ProductReviewModel();
    $category_id = $_POST['category'];
    $product = $_POST['product'];
    $rating = $_POST['rating'];
    $review = $_POST['review'];

    if($PRModel->add($_SESSION['id'], $product, $rating, $review)){
        echo json_encode(['success'=>true, 'msg'=> 'Review submitted successfully!']);
    }else{
        echo json_encode(['success'=>false, 'msg'=> 'Failed to submit review.']);
    }
}


?>