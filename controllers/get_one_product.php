<?php
require_once __DIR__ . '/../config.php';
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $conn = Database::connect();
    $product_id = $_GET['product_id'];

    // $product_id = 1;
    $result =$conn->query("SELECT * FROM products WHERE id = '$product_id'");

    if ($result->num_rows > 0) {
        $data = [];
        $row = $result->fetch_assoc();
        $data = $row;

        $result = $conn->query("SELECT COUNT(*) AS total FROM product_votes WHERE product_id = '$product_id' AND vote = 'like';");
        $row = $result->fetch_assoc();
        $data['like_count'] = $row['total'];

        $result = $conn->query("SELECT COUNT(*) AS total FROM product_votes WHERE product_id = '$product_id' AND vote = 'dislike';");
        $row = $result->fetch_assoc();
        $data['dislike_count'] = $row['total'];
       
        session_start();
        $userID = $_SESSION['id'];

        $result = $conn->query("SELECT * FROM product_votes WHERE user_id = '$userID' AND product_id = '$product_id';");
        $row = $result->fetch_assoc();
        $data['user_vote'] = $row['vote'] ?? '';

        echo json_encode(['success' => true, 'data' => $data]);
    }
    else{ 
        echo json_encode(['success'=> false,'msg'=> 'Failed to fetch']); 
    }
}
?>