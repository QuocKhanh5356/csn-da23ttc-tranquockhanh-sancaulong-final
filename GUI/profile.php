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
    <title>Thông tin cá nhân</title>
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
            <h2><i class="fas fa-user-circle"></i> Thông tin cá nhân</h2>
        </div>
    </header>
    <div class="container">
        <!-- Profile Display Section -->
        <div class="profile-section">
            <div class="profile-header">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <h3><?php echo htmlspecialchars($user['name']); ?></h3>
                <p class="text-muted"><?php echo htmlspecialchars($user['email']); ?></p>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <p><strong><i class="fas fa-phone"></i> Số điện thoại:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
                    <p><strong><i class="fas fa-map-marker-alt"></i> Địa chỉ:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong><i class="fas fa-image"></i> Hình nền:</strong></p>
                    <div class="background-preview rounded">
                        <?php if (!empty($user['background'])): ?>
                            <img src="<?php echo htmlspecialchars($user['background']); ?>" alt="Background" class="img-fluid rounded">
                        <?php else: ?>
                            <div class="background-placeholder">Chưa có hình nền</div>
                        <?php endif; ?>
                    </div>
                    <div class="mt-3 background-upload-section">
                        <form action="update_profile.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="tenKhachHang" value="<?php echo htmlspecialchars($user['name']); ?>">
                            <input type="hidden" name="soDienThoai" value="<?php echo htmlspecialchars($user['phone']); ?>">
                            <input type="hidden" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                            <input type="hidden" name="diaChi" value="<?php echo htmlspecialchars($user['address']); ?>">
                            <div class="mb-2">
                                <label for="background" class="form-label"><i class="fas fa-image"></i> Cập nhật ảnh nền</label>
                                <input type="file" class="form-control" id="background" name="background" accept="image/*">
                            </div>
                            <button type="submit" class="btn btn-secondary btn-sm">Cập nhật hình nền</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Section -->
        <div class="edit-section">
            <h4 class="mb-4"><i class="fas fa-edit"></i> Chỉnh sửa thông tin</h4>
            <form action="update_profile.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="tenKhachHang" class="form-label"><i class="fas fa-user"></i> Họ tên</label>
                    <input type="text" class="form-control" id="tenKhachHang" name="tenKhachHang" value="<?php echo htmlspecialchars($user['name']); ?>">
                </div>

                <div class="mb-3 position-relative">
                    <label for="matKhau" class="form-label"><i class="fas fa-lock"></i> Mật khẩu mới</label>
                    <input type="password" class="form-control" id="matKhau" name="matKhau" value="">
                    <i class="fa-regular fa-eye position-absolute" id="eye1" onclick="myFunction()"></i>
                </div>

                <div class="mb-3 position-relative">
                    <label for="xacNhan" class="form-label"><i class="fas fa-lock"></i> Xác nhận mật khẩu</label>
                    <input type="password" class="form-control" id="xacNhan" name="xacNhan" value="">
                    <i class="fa-regular fa-eye position-absolute" id="eye2" onclick="myFunction1()"></i>
                </div>

                <div class="mb-3">
                    <label for="soDienThoai" class="form-label"><i class="fas fa-phone"></i> Số điện thoại</label>
                    <input type="text" class="form-control" id="soDienThoai" name="soDienThoai" value="<?php echo htmlspecialchars($user['phone']); ?>">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                </div>

                <div class="mb-3">
                    <label for="diaChi" class="form-label"><i class="fas fa-map-marker-alt"></i> Địa chỉ</label>
                    <input type="text" class="form-control" id="diaChi" name="diaChi" value="<?php echo htmlspecialchars($user['address']); ?>">
                </div>

                <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
            </form>
        </div>
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