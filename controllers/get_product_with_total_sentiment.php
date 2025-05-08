<?php
include_once __DIR__ . '/../models/ProductReviewModel.php'; 

//data: ['product' => 'product_name', 'postive' => #, 'negative' => #, 'neutral' => #]

if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $PRModel = new ProductReviewModel();

    $data = $PRModel->getProductsWithTotalSentiment();

    echo json_encode(['success' => true, 'data' => $data]);
}

?>