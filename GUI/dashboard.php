<?php
session_start();
include 'header.php';

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
            include 'userEdit.php';
            break;
        case 'pitchSearch':
            include 'pitchSearch.php';
            break;
        case 'home':
            include 'home.php';
            break;
        case 'summary':
            include 'orderMember.php';
            break;
        case 'logout': 
            session_destroy();
            header("Location: login.php");
            exit();
        default:
            include 'home.php';
            break;
        }
    }else{
        include 'home.php';
    }  

include 'footer.php';