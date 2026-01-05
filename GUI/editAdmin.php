<?php
include 'header_admin.php';
session_start();
require_once __DIR__ . '/../BLL/UserService.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userService = new UserService();
$user = $userService->getUserById($_GET['id']);

if (!$user) {
    echo "User not found.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['user_id'];
    $name = $_POST['tenKhachHang'];
    $password = $_POST['matKhau'];
    $confirmPassword = $_POST['xacNhan'];
    $phone = $_POST['soDienThoai'];
    $email = $_POST['email'];
    $address = $_POST['diaChi'];

    if (!empty($password)) {
        if ($password !== $confirmPassword) {
            echo '<script>alert("Passwords do not match."); location.replace("editAdmin.php?action=edit&id=' . $userId . '");</script>';
            exit();
        }
        $hashedPassword = md5($password);
    } else {
        $hashedPassword = $user['password'];
    }
    
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        echo '<script>alert("Phone number must be 10 digits."); location.replace("editAdmin.php?action=edit&id=' . $userId . '");</script>';
        exit();
    }

    $updated = $userService->updateUser($userId, $name, $hashedPassword, $phone, $email, $address);

    if ($updated) {
        echo '<script>alert("Profile updated successfully."); location.replace("dashboard_admin.php");</script>';
        exit();
    } else {
        echo '<script>alert("Failed to update profile."); location.replace("editAdmin.php?action=edit&id=' . $userId . '");</script>';
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/userEdit.css?v=<?php echo time(); ?>">
</head>

<body>
    <header class="header_pitchManage">
        <div class="header_content">
            <img class="logo" src="./img/logomoi.png" alt="">
            <h2>Sửa tài khoản</h2>
        </div>
    </header>
    <div class="container">
        <form action="" method="post">
            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
            <div class="mb-3">
                <label for="tenKhachHang" class="form-label">Tên Khách hàng</label><br>
                <input type="text" class="form-control" id=" tenKhachHang" name="tenKhachHang"
                    value="<?php echo $user['name']; ?>">
            </div>

            <div class="mb-3">
                <div class="">
                    <label for="matKhau" class="form-label">Mật khẩu</label><br>
                    <input type="password" class="form-control" id="matKhau" name="matKhau" value="">
                </div>
            </div>

            <div class="mb-3">
                <div class="">
                    <label for="xacNhan" class="form-label">Xác nhân mật khẩu</label><br>
                    <input type="password" class="form-control" id="xacNhan" name="xacNhan" value="">
                </div>
            </div>

            <div class="mb-3">
                <label for="soDienThoai" class="form-label">Số điện thoại</label><br>
                <input type="text" class="form-control" id="soDienThoai" name="soDienThoai"
                    value="<?php echo $user['phone']; ?>">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label><br>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>">
            </div>

            <div class="mb-3">
                <label for="diaChi" class="form-label">Địa chỉ</label><br>
                <input type="text" class="form-control" id="diaChi" name="diaChi"
                    value="<?php echo $user['address']; ?>">
            </div>

            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        </form>
    </div>
</body>

</html>
<?php 
    include 'footer.php';
?>