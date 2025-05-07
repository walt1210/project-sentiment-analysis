<?php
require_once __DIR__ ."/../config.php";
require_once __DIR__ ."/../models/UserModel.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $userModel = new UserModel();
    
    $user_id = $_POST['id'];
    $role = $_POST['role'];
    $role_id = 0;

    if($role == 'admin'){
        $role_id = 2;
    }
    elseif($role == 'user'){
        $role_id = 1;
    }
    $success = $userModel->updateRole($user_id, $role_id);
    echo json_encode(['success'=>$success]);

}



?>