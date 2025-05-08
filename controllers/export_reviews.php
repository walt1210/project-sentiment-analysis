<?php
require_once __DIR__ . "/../config.php";
require_once __DIR__ . "/../models/ProductReviewModel.php";

$reviewModel = new ProductReviewModel();
$reviewModel->getCSV(); 

?>