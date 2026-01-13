<?php
require_once __DIR__ . '/../BLL/pitchManageService.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: dashboard_admin.php?pg=selectPitch");
    exit();
}

$id = (int)$_GET['id'];
$pitch = getPitchByIdForEdit($id); // Giả sử có function này, nếu không, query trực tiếp.

if (!$pitch) {
    echo "Sân không tồn tại!";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $updated_at = date('Y-m-d H:i:s');
    $description = trim($_POST['Description']);
    // Debug: echo "Description: " . $description . "<br>";
    $result = checkUpdatePitch($id, $_POST['pitchName'], $_POST['pitchTimeStart'], $_POST['pitchTimeEnd'], $description, $_POST['price_per_hour'], 
    $_POST['price_per_peak_hour'], $_POST['is_maintenance'], $_POST['pitch_type_id'], $updated_at);
    if ($result === true) {
        echo "Cập nhật thành công. Description: " . htmlspecialchars($description);
        // echo '<script type="text/javascript">alert("Đã cập nhật sân thành công."); location.replace("dashboard_admin.php?pg=pitchManage");</script>';
        // exit();
    } else {
        $error = $result;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa sân cầu lông</title>
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
    </style>
</head>

<body>
    <div class="container">
        <h2><i class="fas fa-edit"></i> Chỉnh sửa sân cầu lông</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="pitchName" class="form-label"><i class="fas fa-tag"></i> Tên sân cầu lông:</label>
                    <input type="text" class="form-control" name="pitchName" value="<?php echo htmlspecialchars($pitch['name']); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="pitchTimeStart" class="form-label"><i class="fas fa-clock"></i> Thời gian bắt đầu:</label>
                    <input type="time" class="form-control" name="pitchTimeStart" value="<?php echo htmlspecialchars($pitch['time_start']); ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="pitchTimeEnd" class="form-label"><i class="fas fa-clock"></i> Thời gian kết thúc:</label>
                    <input type="time" class="form-control" name="pitchTimeEnd" value="<?php echo htmlspecialchars($pitch['time_end']); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="Description" class="form-label"><i class="fas fa-info-circle"></i> Mô tả:</label>
                    <input type="text" class="form-control" name="Description" value="<?php echo htmlspecialchars($pitch['description']); ?>">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="price_per_hour" class="form-label"><i class="fas fa-dollar-sign"></i> Giá sân trong 1 giờ:</label>
                    <input type="number" class="form-control" name="price_per_hour" value="<?php echo htmlspecialchars($pitch['price_per_hour']); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="price_per_peak_hour" class="form-label"><i class="fas fa-dollar-sign"></i> Giá sân lúc cao điểm:</label>
                    <input type="number" class="form-control" name="price_per_peak_hour" value="<?php echo htmlspecialchars($pitch['price_per_peak_hour']); ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="is_maintenance" class="form-label"><i class="fas fa-tools"></i> Bảo trì:</label>
                    <select name="is_maintenance" class="form-select" required>
                        <option value="0" <?php echo $pitch['is_maintenance'] == 0 ? 'selected' : ''; ?>>Đang hoạt động</option>
                        <option value="1" <?php echo $pitch['is_maintenance'] == 1 ? 'selected' : ''; ?>>Đang bảo trì</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="pitch_type_id" class="form-label"><i class="fas fa-list"></i> Mã loại sân:</label>
                    <input type="number" class="form-control" name="pitch_type_id" value="<?php echo htmlspecialchars($pitch['pitch_type_id']); ?>" required>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg me-3"><i class="fas fa-save"></i> Cập nhật sân</button>
                <a href="dashboard_admin.php?pg=selectPitch" class="btn btn-secondary btn-lg"><i class="fas fa-arrow-left"></i> Quay lại</a>
            </div>
        </form>
    </div>
</body>

</html>