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
    <style>
        body {
            background-image: url('<?php echo !empty($user['background']) ? $user['background'] : '../img/background.jpg'; ?>') !important;
        }
    </style>
</head>

<body>
    <header class="header_pitchManage">
        <div class="header_content">
            <h2>Sửa thông tin cá nhân</h2>
        </div>
    </header>
    <div class="container">
        <form action="update_profile.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="tenKhachHang" class="form-label"><i class="fas fa-user"></i> Họ tên</label><br>
                <input type="text" class="form-control" id="tenKhachHang" name="tenKhachHang"
                    value="<?php echo $user['name']; ?>">
            </div>

            <div class="mb-3 position-relative">
                <label for="matKhau" class="form-label"><i class="fas fa-lock"></i> Mật khẩu</label><br>
                <input type="password" class="form-control" id="matKhau" name="matKhau" value="">
                <i class="fa-regular fa-eye position-absolute" id="eye1" onclick="myFunction()"></i>
            </div>

            <div class="mb-3 position-relative">
                <label for="xacNhan" class="form-label"><i class="fas fa-lock"></i> Xác nhận mật khẩu</label><br>
                <input type="password" class="form-control" id="xacNhan" name="xacNhan" value="">
                <i class="fa-regular fa-eye position-absolute" id="eye2" onclick="myFunction1()"></i>
            </div>

            <div class="mb-3">
                <label for="soDienThoai" class="form-label"><i class="fas fa-phone"></i> Số điện thoại</label><br>
                <input type="text" class="form-control" id="soDienThoai" name="soDienThoai"
                    value="<?php echo $user['phone']; ?>">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email</label><br>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>">
            </div>

            <div class="mb-3">
                <label for="diaChi" class="form-label"><i class="fas fa-map-marker-alt"></i> Địa chỉ</label><br>
                <input type="text" class="form-control" id="diaChi" name="diaChi"
                    value="<?php echo $user['address']; ?>">
            </div>

            <div class="mb-3">
                <label for="background" class="form-label"><i class="fas fa-image"></i> Hình nền (Upload file ảnh)</label><br>
                <input type="file" class="form-control" id="background" name="background" accept="image/*">
                <?php if (!empty($user['background'])): ?>
                        <small class="form-text text-muted">Hình nền hiện tại:</small>
                        <div class="mt-2 background-preview rounded" style="max-width: 220px;">
                            <img src="<?php echo htmlspecialchars($user['background']); ?>" alt="Background" class="img-fluid rounded">
                        </div>
                    <?php else: ?>
                        <small class="form-text text-muted">Chưa có hình nền hiện tại.</small>
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