<?php
require_once __DIR__ . '/../BLL/EmployeeService.php';

$employeeService = new EmployeeService();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    if ($employeeService->isEmailExist($email)) {
        $error = "Email đã tồn tại!";
    } elseif (!$employeeService->validatePhoneNumber($phone)) {
        $error = "Số điện thoại không hợp lệ!";
    } else {
        $result = $employeeService->addEmployee($name, $email, $password, $phone, $address);
        if ($result) {
            echo '<script type="text/javascript">alert("Nhân viên đã được thêm thành công."); location.replace("dashboard_admin.php?pg=employeeManage");</script>';
            exit();
        } else {
            $error = "Có lỗi xảy ra, vui lòng thử lại!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm nhân viên</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/addUser.css?v=<?php echo time(); ?>">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 40px;
            margin-top: 50px;
            margin-bottom: 50px;
            flex: 1;
        }
        h2 {
            background: linear-gradient(135deg, #ff69b4 0%, #ff1493 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
        }
        .form-control {
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            padding: 12px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        .form-control:focus {
            border-color: #ff69b4;
            box-shadow: 0 0 10px rgba(255,105,180,0.3);
        }
        .btn-primary {
            background: linear-gradient(135deg, #ff69b4 0%, #ff1493 100%);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: bold;
            transition: transform 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255,105,180,0.4);
        }
        .btn-secondary {
            background: #6c757d;
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: bold;
            transition: transform 0.3s ease;
        }
        .btn-secondary:hover {
            transform: translateY(-2px);
            background: #5a6268;
        }
        .alert {
            border-radius: 10px;
            font-weight: 500;
        }
        .mb-3 {
            margin-bottom: 25px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Thêm nhân viên mới</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label"><i class="fas fa-user"></i> Họ tên</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label"><i class="fas fa-envelope"></i> Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label"><i class="fas fa-lock"></i> Mật khẩu</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label"><i class="fas fa-phone"></i> Số điện thoại</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label"><i class="fas fa-map-marker-alt"></i> Địa chỉ</label>
                <textarea class="form-control" id="address" name="address" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Thêm nhân viên</button>
            <a href="dashboard_admin.php?pg=employeeManage" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</a>
        </form>
    </div>
</body>

</html>