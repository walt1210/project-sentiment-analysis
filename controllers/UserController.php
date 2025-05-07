<?php
require_once __DIR__ ."/../config.php";
require_once __DIR__ ."/../models/UserModel.php";

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    // $userModel = new UserModel();
    // $users = $userModel->getAll();
    // echo json_encode(['data'=>$users]);

    $conn = Database::connect();

    $sql = "SELECT 
        users.*,
        roles.name AS 'role_name',
        latest_logins.latest_login
        FROM users
        LEFT JOIN (
        SELECT user_id, MAX(log_time) AS latest_login
        FROM activity_logs
        WHERE log_action = 'login'
        GROUP BY user_id
        ) AS latest_logins
        ON users.id = latest_logins.user_id
        LEFT JOIN roles ON users.role_id = roles.id
        ;";

    $result = $conn->query($sql);
    echo json_encode(['data' => $result->fetch_all(MYSQLI_ASSOC)]) ;

}



?>