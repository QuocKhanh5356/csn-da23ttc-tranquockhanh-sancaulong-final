<?php
require_once __DIR__ . '/../BLL/pitchManageService.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        $tenSanBong = $_POST['tenSanCauLong'];
        $hinhAnh = trim($_POST['image']);
        $idResult = getID($tenSanBong);

        if ($idResult !== false && $idResult->num_rows > 0) {
            $idRow = $idResult->fetch_assoc();
            $id = $idRow['id'];

            if (ThemAnh($hinhAnh, $id)) {
                echo '<script type="text/javascript">alert("Đã thêm hình ảnh thành công."); location.replace("dashboard_admin.php?pg=pitchManage");</script>';
                exit();
            } else {
                $error = "Lỗi khi thêm hình ảnh.";
            }
        } else {
            $error = "Không tìm thấy sân cầu lông.";
        }
    }
}

$result = getDataPitchforTable();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm hình ảnh sân cầu lông</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        body {
            background-color: #fce4ec; /* Hồng nhạt */
        }
        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 30px;
            margin-top: 50px;
        }
        h2 {
            color: #e91e63;
            text-align: center;
            margin-bottom: 30px;
        }
        .btn-primary {
            background-color: #e91e63 !important; /* Hồng đậm */
            border-color: #e91e63 !important;
        }
        .btn-secondary {
            background-color: #f8bbd9 !important; /* Hồng nhạt */
            border-color: #f8bbd9 !important;
            color: #000 !important;
        }
        .form-label {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2><i class="fas fa-image"></i> Thêm hình ảnh sân cầu lông</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="tenSanCauLong" class="form-label"><i class="fas fa-volleyball-ball"></i> Tên sân cầu lông:</label>
                <select name="tenSanCauLong" class="form-select" required>
                    <option value="">Chọn sân</option>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <option value="<?php echo htmlspecialchars($row['name']); ?>"><?php echo htmlspecialchars($row['name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label"><i class="fas fa-link"></i> Liên kết hình ảnh:</label>
                <input type="url" name="image" class="form-control" placeholder="Nhập URL hình ảnh" required>
            </div>
            <div class="text-center">
                <button type="submit" name="add" class="btn btn-primary btn-lg me-3"><i class="fas fa-save"></i> Thêm hình ảnh</button>
                <a href="dashboard_admin.php?pg=pitchManage" class="btn btn-secondary btn-lg"><i class="fas fa-arrow-left"></i> Quay lại</a>
            </div>
        </form>
    </div>
</body>

</html>