<?php
session_start();
require_once __DIR__ . '/../BLL/UserService.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['user_id'];
    $name = $_POST['tenKhachHang'];
    $password = $_POST['matKhau'];
    $confirmPassword = $_POST['xacNhan'];
    $phone = $_POST['soDienThoai'];
    $email = $_POST['email'];
    $address = $_POST['diaChi'];

    $userService = new UserService();
    $currentUser = $userService->getUserById($userId);
    $type = $currentUser['type'];

    $hashedPassword = $currentUser['password'];

    if (!empty($password)) {
        if ($password !== $confirmPassword) {
            echo '<script type="text/javascript">alert("Passwords do not match."); location.replace("dashboard.php?pg=userEdit");</script>';
            exit();
        }
        if (strlen($password) < 8) {
            echo '<script type="text/javascript">alert("Password must have at least 8 characters."); location.replace("dashboard.php?pg=userEdit");</script>';
        exit();
        }
        if (!preg_match('/^[0-9]{10}$/', $phone)) {
            echo '<script type="text/javascript">alert("Phone number must be 10 digits."); location.replace("dashboard.php?pg=userEdit");</script>';
            exit();
        }
        $hashedPassword = md5($password);
    }

    
    
    $updated = $userService->updateUser($userId, $name, $hashedPassword, $phone, $email, $address);

    if ($updated) {
        if ($type == 1) {
            echo '<script type="text/javascript">alert("Profile updated successfully."); location.replace("dashboard_admin.php");</script>';
        } elseif ($type == 2) {
            echo '<script type="text/javascript">alert("Profile updated successfully."); location.replace("dashboard.php?pg=userEdit");</script>';
        } else {
            echo '<script type="text/javascript">alert("Unknown user type."); location.replace("dashboard.php");</script>';
        }
    } else {
        echo '<script type="text/javascript">alert("Failed to update profile."); location.replace("dashboard.php?pg=userEdit");</script>';
    }
}