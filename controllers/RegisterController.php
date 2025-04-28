<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../models/UserModel.php';

$UserModel = new UserModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = $_POST['fname'] ??'';
    $lname = $_POST['lname'] ??'';
    $email = $_POST['email'] ??'';
    $password = $_POST['password'] ??'';
    $password = md5($password);
    $confirm_password = $_POST['confirm_password'] ??'';
    $field_complete = true;
    $nameErr = '';
    $emailErr = '';

    foreach($_POST as $key => $value){
        if (empty($value)){
            $field_complete = false;
        }
    }

    if (!preg_match("/^[a-zA-Z-' ]*$/",$fname) || !preg_match("/^[a-zA-Z-' ]*$/",$lname)) {
        $nameErr = "Invalid name. Only letters and white space allowed";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    }

    if($nameErr=='' && $emailErr == '' && $field_complete && $UserModel->add($email, $fname, $lname, $password)){
        echo json_encode(['success'=> true, 'message'=> 'Registered successfuly',]);
    }
    else{
        echo json_encode(['success'=> false,'message'=> 'Registration Failed', 'errors' => [$nameErr, $emailErr]]);
    }
}

?>