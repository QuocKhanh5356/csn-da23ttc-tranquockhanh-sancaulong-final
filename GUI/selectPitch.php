<?php
require_once __DIR__ . '/../BLL/pitchManageService.php';
$result = getDataPitchforTable();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chọn sân để chỉnh sửa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="./css/pitchManage.css?v=<?php echo time(); ?>">
    <style>
        body {
            background-color: #e3f2fd;
        }
        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 50px;
        }
        h2 {
            color: rgba(36, 122, 213, 1);
            text-align: center;
            margin-bottom: 30px;
        }
        .btn-primary {
            background-color: #afd4fbff !important;
            border-color: #9ec7f4ff !important;
        }
        .btn-secondary {
            background-color: #6c757d !important;
            border-color: #6c757d !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2><i class="fas fa-edit"></i> Chọn sân để chỉnh sửa</h2>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên sân</th>
                    <th>Thời gian mở cửa</th>
                    <th>Thời gian đóng cửa</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['time_start']; ?></td>
                    <td><?php echo $row['time_end']; ?></td>
                    <td>
                        <a href="dashboard_admin.php?pg=editPitch&id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Chỉnh sửa</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="text-center mt-4">
            <a href="dashboard_admin.php?pg=pitchManage" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay lại</a>
        </div>
    </div>
</body>

</html>