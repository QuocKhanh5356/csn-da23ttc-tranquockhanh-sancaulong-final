<?php
require_once __DIR__ . '/../BLL/UserService.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userService = new UserService();
$user = $userService->getUserById($_SESSION['user_id']);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Sửa thông tin cá nhân</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/userEdit.css?v= <?php echo time(); ?>">
</head>

<body>
    <header class="header_pitchManage">
        <div class="header_content">
            <h2>Sửa thông tin cá nhân</h2>
        </div>
    </header>
    <div class="container">
        <form action="update_profile.php" method="post">
            <div class="mb-3">
                <label for="tenKhachHang" class="form-label">Họ tên</label><br>
                <input type="text" class="form-control" id="tenKhachHang" name="tenKhachHang"
                    value="<?php echo $user['name']; ?>">
            </div>

            <div class="mb-3 position-relative">
                <label for="matKhau" class="form-label">Mật khẩu</label><br>
                <input type="password" class="form-control" id="matKhau" name="matKhau" value="">
                <i class="fa-regular fa-eye position-absolute" id="ia" onclick="myFunction()"></i>
            </div>

            <div class="mb-3 position-relative">
                <label for="xacNhan" class="form-label">Xác nhận mật khẩu</label><br>
                <input type="password" class="form-control" id="xacNhan" name="xacNhan" value="">
                <i class="fa-regular fa-eye position-absolute" id="ia" onclick="myFunction1()"></i>
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

    <script>
    let temp = true;
    let temp1 = true;

    function myFunction() {
        if (temp) {
            document.getElementById('matKhau').type = "text";
            temp = false;
        } else {
            document.getElementById('matKhau').type = "password";
            temp = true;
        }
    }

    function myFunction1() {
        if (temp1) {
            document.getElementById('xacNhan').type = "text";
            temp1 = false;
        } else {
            document.getElementById('xacNhan').type = "password";
            temp1 = true;
        }
    }
    </script>
</body>

</html>