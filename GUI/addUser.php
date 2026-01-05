<?php
require_once __DIR__ . '/../BLL/UserService.php';
include 'header_admin.php';
$userService = new UserService();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $type = trim($_POST['type']);
    $password = trim($_POST['password']);

    // Check if the password length is at least 8 characters before hashing
    if (strlen($password) < 8) {
        echo '<script type="text/javascript">alert("Mật khẩu phải có ít nhất 8 ký tự."); location.replace("addUser.php");</script>';
        exit();
    }

    // Hash the password after validation
    $hashedPassword = md5($password);

    // Check if the email already exists
    if($userService->isEmailExist($email)){
        echo '<script type="text/javascript">alert("Email đã tồn tại trong hệ thống"); location.replace("addUser.php");</script>';
        exit();
    }

    if (!preg_match('/^[0-9]{10}$/', $phone)) {
         echo '<script type="text/javascript">alert("Số điện thoại phải có 10 chữ số."); location.replace("addUser.php");</script>';
        exit();
    }
    
    $result = $userService->addUser($name, $email, $hashedPassword, $phone, $address, $type);
    if ($result) {
        echo '<script type="text/javascript">alert("Thêm tài khoản thành công."); location.replace("dashboard_admin.php");</script>';
        exit();
    } else {
        echo "Failed to add user.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm tài khoản</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/addUser.css?v=<?php echo time(); ?>">
</head>

<body>
    <header class="header_pitchManage">
        <div class="header_content">
            <img class="logo" src="./img/logomoi.png" alt="not found image.">
            <h2>Thêm tài khoản</h2>
        </div>
    </header>
    <div class="container">
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Họ tên</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Số điện thoại</label>
                <input type="text" id="phone" name="phone" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Địa chỉ</label>
                <input type="text" id="address" name="address" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Loại tài khoản</label>
                <select id="type" name="type" class="form-control" required>
                    <option value="1">Admin</option>
                    <option value="2">Customer</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Thêm mới</button>
        </form>
    </div>
</body>

</html>

<?php
include 'footer.php';
?>