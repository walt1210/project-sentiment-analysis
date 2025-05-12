<?php
require_once __DIR__ . '/../config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $conn = Database::connect();
    $result = $conn->query("SELECT id, name FROM categories"); 

    if ($result) {
        echo json_encode($result->fetch_all(MYSQLI_ASSOC));
    } else {
        echo json_encode(['error' => 'Failed to fetch categories.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
?>