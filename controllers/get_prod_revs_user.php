<?php
require_once __DIR__ . '/../models/ProductReviewModel.php';

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $PRModel = new ProductReviewModel();
    session_start();
    $user_id = $_SESSION['id'];
    $data = $PRModel->getByIds(user_id: $user_id);


    if(!empty($data)){
        echo json_encode( ['success' => true, 'data' => $data, 'message' => "Reviews retrieved."] );
    }
    else{
        echo json_encode( ['success' => false, 'message' => 'No reviews found'] );
    }

}

?>