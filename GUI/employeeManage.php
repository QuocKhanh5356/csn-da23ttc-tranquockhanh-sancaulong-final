<?php
require_once __DIR__ . '/../BLL/EmployeeService.php';

// Khởi tạo EmployeeService để sử dụng các phương thức xử lý nhân viên
$employeeService = new EmployeeService();

// Xử lý các action (nếu có)
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    
    switch ($action) {
        case 'toggle':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $result = $employeeService->toggleEmployeeActive($id);
                if ($result) {
                    echo '<script type="text/javascript">alert("Trạng thái nhân viên đã được cập nhật."); location.replace("dashboard_admin.php?pg=employeeManage");</script>';
                    exit(); 
                } else {
                    echo "Có lỗi xảy ra, vui lòng thực hiện lại thao tác!";
                }
            }
            break;
        case 'delete':
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $result = $employeeService->deleteEmployee($id);
                if ($result) {
                    echo '<script type="text/javascript">alert("Nhân viên đã được xóa thành công."); location.replace("dashboard_admin.php?pg=employeeManage");</script>';
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
$employees = $employeeService->getAllEmployees();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhân viên</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/accountManage.css?v= <?php echo time(); ?>">
    <style>
        .status-active {
            color: green;
            font-weight: bold;
        }
        .status-inactive {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <header class="header_pitchManage">
        <div class="header_content">
            <h2>Quản lý nhân viên</h2>
            <div class="addUser">
                <a href="addEmployee.php">Thêm nhân viên</a>
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
            <th>Trạng thái</th>
            <th style="text-align: center;">Thao tác</th>
        </tr>
        <?php foreach ($employees as $employee): ?>
        <tr>
            <td><?php echo $employee['id']; ?></td>
            <td><?php echo $employee['name']; ?></td>
            <td><?php echo $employee['email']; ?></td>
            <td><?php echo $employee['phone']; ?></td>
            <td><?php echo $employee['address']; ?></td>
            <td><?php echo $employee['active'] ? '<span class="status-active">Hoạt động</span>' : '<span class="status-inactive">Không hoạt động</span>'; ?></td>
            <td class="usecase" style="text-align: center;">
                <a href="editEmployee.php?id=<?php echo $employee['id']; ?>" style="margin-right: 10px;"><i class="fa-solid fa-gear"></i></a>
                <a href="employeeManage.php?action=toggle&id=<?php echo $employee['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn thay đổi trạng thái nhân viên này?')" style="margin-right: 10px;"><i class="fa-solid fa-toggle-on"></i></a>
                <a href="employeeManage.php?action=delete&id=<?php echo $employee['id']; ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?')" class="xoa"><i class="fa-solid fa-trash-can"></i></a>
            </td>
        </tr>

        <?php endforeach; ?>

    </table>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.table').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/vi.json"
                }
            });
        });
    </script>
</body>

</html>