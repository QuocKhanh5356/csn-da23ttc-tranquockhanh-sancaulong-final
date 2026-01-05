<?php
session_start();
require_once __DIR__ . '/../BLL/UserService.php';
$userService = new UserService();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $password = trim($_POST['password']);
    $confirmPass = trim($_POST['confirmPass']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $type = 2;

    $_SESSION['form_data'] = $_POST; 

    if (strlen($password) < 8) {
        $_SESSION['error'] = "Mật khẩu phải có tối thiểu 8 kí tự.";
        header('Location: signin.php');
        exit;
    }

    if ($password !== $confirmPass) {
        $_SESSION['error'] = "Mật khẩu không trùng khớp";
        header('Location: signin.php');
        exit;
    }

    if(!$userService->validatePhoneNumber($phone)){
        $_SESSION['error'] = "Số điện thoại không hợp lệ";
        header('Location: signin.php');
        exit;
    }
    if ($userService->isEmailExist($email)) {
        $_SESSION['error'] = "Email đã tồn tại trong hệ thống.";
        header('Location: signin.php');
        exit;
    }

    $hashedPassword = md5($password);

    $result = $userService->addUser($lastname . ' ' . $firstname, $email, $hashedPassword, $phone, $address, $type);

    if ($result) {
        unset($_SESSION['form_data']);
        echo "<script type='text/javascript'>alert('Đăng kí thành công.'); location.replace('login.php');</script>";
    } else {
        $_SESSION['error'] = "Đăng kí thất bại.";
        header('Location: signin.php');
    }
} else {
    $_SESSION['error'] = "Quá trình gửi thông tin lên server thất bại! Vui Lòng kiểm tra lại";
    header('Location: signin.php');
}