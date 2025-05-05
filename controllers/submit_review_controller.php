<?php
require_once __DIR__ ."/../models/ProductReviewModel.php";

if(($_SERVER['REQUEST_METHOD'] == 'POST')){
    session_start();
    $PRModel = new ProductReviewModel();
    //$category_id = $_POST['category'] ?? null;
    
    $action = $_POST['action'] ?? null;
    $success = false;
    $message = "";

    if($action == 'add'){
        $product = $_POST['product'] ?? null;
        $rating = $_POST['rating'] ?? null;
        $review = $_POST['review'] ?? null;
        $success = $PRModel->add($_SESSION['id'], $product, $rating, $review);
        $message = "Review submitted successfully!";
    }
    else if($action == 'edit'){
        
        $id = $_POST['review_id'] ?? null;
        $rating = $_POST['rating'] ?? null;
        $review = $_POST['review'] ?? null;
        $success = $PRModel->update($id, $rating, $review);
        $message = 'Review updated successfully!';
    }
    elseif($action == 'delete'){
        $id = $_POST['review_id'] ?? null;
        $success = $PRModel->delete($id);
        $message = 'Review deleted successfully!';
    }

    if($success){
        echo json_encode(['success'=>true, 'msg'=> $message]);
    }else{
        echo json_encode(['success'=>false, 'msg'=> 'Failed to submit review.']);
    }
}


?>