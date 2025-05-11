<?php
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    require_once __DIR__ . '/../models/ProductReviewModel.php'; 
    $PRModel = new ProductReviewModel();
    $data = $PRModel->getAllWithSentiment();
    echo json_encode(['success' => true, 'data' => $data]);
}

?>