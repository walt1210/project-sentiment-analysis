<?php
session_start();

header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

if (!isset($_SESSION['email']) || $_SESSION['role_id'] != 1) {
    // If not regular user, kick them out
    header('Location: ../../index.php');
    exit();
}

// Continue loading the user dashboard...
?>
