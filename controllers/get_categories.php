<?php
require_once __DIR__ . '/../config.php';
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $conn = Database::connect();
    $result =$conn->query("SELECT * FROM categories");

   echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}
?>