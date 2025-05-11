<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

if(isset($_SESSION['email'])){
    
    //IF SUPER ADMIN
    if($_SESSION['role_id'] == 3){
        header("Location: views/super_admin/dashboard.php");
    }
    //IF ADMIN
    elseif($_SESSION['role_id'] == 2 ){
      header("Location: views/admin/dashboard.php");
    }
    //IF REGULAR USER
    elseif($_SESSION['role_id'] == 1 ){
        header("Location: views/user/dashboard.php");
    }
    die();
  }

?>