<?php
session_start();
include 'header_admin.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if(isset($_GET['pg'])){
    $pg = $_GET['pg'];

    switch($pg){
        case 'userEdit':
            include 'editAdmin.php';
            break;
        case 'pitchManage':
            include 'pitchManage.php';
            break;
        case 'accountManage':
            include 'accountManage.php';
            break;
        case 'summary': 
            include 'orderManage.php'; 
            break;
        case 'promotionManage':
            include 'promotionManage.php';
            break;
        case 'logout': 
            session_destroy();
            header("Location: login.php");
            exit();
        default:
            include 'accountManage.php';
            break;
    }
}else{
    include 'accountManage.php';
}  

include 'footer.php';