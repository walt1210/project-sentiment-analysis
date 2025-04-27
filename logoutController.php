<?php
require_once __DIR__ . '/models/ActivityLogModel.php';
$LogModel = new ActivityLogModel();
   session_start();
   $userID = $_SESSION['id'];

   if(session_unset() && session_destroy() ) {
      //session_destroy();
      //$location = __DIR__ . 'index.php';
      $LogModel->add($userID, 'logout');
      header("Location: index.php" );
   }
   exit();
?>