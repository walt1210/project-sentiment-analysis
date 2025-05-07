<?php
include_once __DIR__ . '/../models/ProductReviewModel.php'; 

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $PRModel = new ProductReviewModel();

    $data = $PRModel->getProductsWithTotalSentiment();

    echo json_encode(['success' => true, 'data' => $data]);
}

?>