<?php
require_once __DIR__ . '/../config.php';

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $conn = Database::connect();
    $result =$conn->query("SELECT * FROM products");
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    
    echo json_encode(['success'=>true, 'data'=>$data]);

   // echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}
?> 
