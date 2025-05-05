<?php
require_once __DIR__ . '/../config.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $conn = Database::connect();
    //add/update prod vote

    // Read the raw JSON input
    $data = json_decode(file_get_contents("php://input"), true);

    session_start();
    $user_id = $_SESSION['id'];
    $product_id = $data['product_id'];
    $vote = $data['user_vote'];
    $addProductVote = false;
    $msg = '';

    // Perform DB logic here (e.g., add or remove like)
    $sql = "INSERT INTO product_votes (user_id, product_id, vote)
    VALUES (?, ?, ?)
    ON DUPLICATE KEY UPDATE vote = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiss", $user_id, $product_id, $vote, $vote);

    if ($stmt->execute()) {
       $addProductVote = true;
       $msg = "successfully added product vote";
    } else {
       $msg = "Error: " . $stmt->error;
    }

    // Respond with JSON
    header('Content-Type: application/json');
    echo json_encode(['status' => 'success', 'success' => $addProductVote, 'msg' => $msg]);

}
?>