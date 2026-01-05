<?php
require_once __DIR__ . '/../BLL/UserService.php';

// Khởi tạo UserService để sử dụng các phương thức xử lý người dùng
$userService = new UserService();

// Xử lý các action (nếu có)
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    
    switch ($action) {
        case 'delete':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $result = $userService->deleteUser($id);
                if ($result) {
                    echo '<script type="text/javascript">alert("Tài khoản đã được xóa thành công."); location.replace("dashboard_admin.php");</script>';
                    exit(); 
                } else {
                    echo "Có lỗi xảy ra, vui lòng thực hiện lại thao tác!";
                }
            }
            break;
        default:
            break;
    }
}
$users = $userService->getAllUsers();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bảo trì tài khoản</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/accountManage.css?v= <?php echo time(); ?>">
</head>

<body>
    <header class="header_pitchManage">
        <div class="header_content">
            <h2>Quản lý tài khoản</h2>
            <div class="addUser">
                <a href="addUser.php">Thêm</a>
            </div>
        </div>
    </header>
    <table border="0" cellspacing="0" class="table table-striped table-hover">
        <tr>
            <th>#</th>
            <th>Họ Tên</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>Loại tài khoản</th>
            <th style="text-align: center;">Thao tác</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo $user['name']; ?></td>
            <td><?php echo $user['email']; ?></td>
            <td><?php echo $user['phone']; ?></td>
            <td><?php echo $user['address']; ?></td>
            <td><?php echo $userService->findNameType( $user['type'])?></td>
            <td class="usecase" style="text-align: center;">
                <a href="editAdmin.php?action=edit&id=<?php echo $user['id']; ?>" style="margin-right: 10px;"><i
                        class="fa-solid fa-gear"></i></a>
                <a href="accountManage.php?action=delete&id=<?php echo $user['id']; ?>"
                    onclick="return confirm('Bạn có chắc chắn muốn xóa tài khoản này?')" class="xoa"><i
                        class="fa-solid fa-trash-can"></i></a>
            </td>
        </tr>

        <?php endforeach; ?>

    </table>
</body>

</html>