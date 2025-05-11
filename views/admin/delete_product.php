<?php
require_once __DIR__ . '/session.php'; 
require_once __DIR__ . '/../../models/ProductsModel.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $productId = intval($_GET['id']);  

    // Create a connection
    $conn = Database::connect();

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Delete sentiments related to the product (if any)
        $stmt1 = $conn->prepare("DELETE FROM sentiments WHERE product_review_id IN (SELECT id FROM product_review_comments WHERE product_id = ?)");
        $stmt1->bind_param("i", $productId);
        $stmt1->execute();

        // Delete product review comments related to the product (if any)
        $stmt2 = $conn->prepare("DELETE FROM product_review_comments WHERE product_id = ?");
        $stmt2->bind_param("i", $productId);
        $stmt2->execute();

        // Delete votes related to the product (if any)
        $stmt3 = $conn->prepare("DELETE FROM product_votes WHERE product_id = ?");
        $stmt3->bind_param("i", $productId);
        $stmt3->execute();

        // Delete the product itself
        $stmt4 = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt4->bind_param("i", $productId);
        $stmt4->execute();

        // Check if the product itself was deleted
        if ($stmt4->affected_rows > 0) {
            $conn->commit();
            echo json_encode(['success' => true, 'message' => 'Product deleted successfully.']);
        } else {
            $conn->rollback();
            echo json_encode(['success' => false, 'message' => 'Failed to delete the product.']);
        }
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => 'Error occurred: ' . $e->getMessage()]);
    }

    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
