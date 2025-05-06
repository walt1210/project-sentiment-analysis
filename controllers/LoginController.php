<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/ActivityLogModel.php';

$UserModel = new UserModel();
$LogModel = new ActivityLogModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password_ = $_POST['password'] ?? '';
    $password_ = md5($password_);

    $row = $UserModel->getbyEmail($email);

    if ($row) {
        if ( $password_ == $row['password_']){
            session_start();
            $_SESSION["first_name"] = $row['first_name'];
            $_SESSION["last_name"] = $row['last_name'];
            $_SESSION["id"] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION["role_id"] = $row['role_id'];
            $LogModel->add($row['id'], 'login');
            if($row['role_id'] == 1){   //if standard user
                header('Location: ../views/user/dashboard.php');
                exit();
            }
            elseif($row['role_id' == 2]){    //if admin
                header('Location: ../views/admin/dashboard.php');
                exit();
            }
            elseif($row['role_id'] == 3){    //if super admin
                header('Location: ../views/super_admin/dashboard.php');
                exit();
            }
        }
        else{
            echo '<script> alert("Wrong Password");
            window.location.href = "../login.php";

            </script>';
        }
    }
    else{
        echo '<script> alert("Register First"); 
         window.location.href = "../register.php";</script>';
    }

}

?>