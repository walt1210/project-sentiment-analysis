<?php
//stars, comment
//select all where prod id = #
// left join user fname, lnam user_id

require_once __DIR__ . '/../config.php';
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $conn = Database::connect();
    $product_id = $_GET['product_id'];

    //$product_id = 1;

    $sql = "SELECT
    CONCAT(users.first_name, ' ', users.last_name) AS user_name,
    products.name,
    product_review_comments.rating,
    product_review_comments.review_text
    FROM product_review_comments
    LEFT JOIN users ON product_review_comments.user_id = users.id
    LEFT JOIN products on product_review_comments.product_id = products.id
    WHERE product_review_comments.product_id = '$product_id'
    ";
    $result = $conn->query( $sql );

    echo json_encode( ['success' => true, 'data' => $result->fetch_all(MYSQLI_ASSOC)] );

    //echo var_dump($result->fetch_all(MYSQLI_ASSOC));



}

?>