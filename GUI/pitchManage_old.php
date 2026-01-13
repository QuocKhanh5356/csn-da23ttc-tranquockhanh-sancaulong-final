<?php
require_once __DIR__ . '/../BLL/pitchManageService.php';
$result = getDataPitchforTable();
$result3 = getDataPitchforTable();
$result4 = getDataPitchforTable();
$showForm = isset($_POST['ButThem']);
$showForm2= isset($_POST['ButSua']);
$showForm3= isset($_POST['Anh']);
$showForm4 = isset($_POST['ThemHinhAnh']);
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sân cầu lông</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <style>
        body {
            background-color: #fce4ec; /* Hồng nhạt */
            font-family: 'Arial', sans-serif;
        }
        .header {
            background-color: #e91e63; /* Hồng đậm */
            color: white;
            padding: 20px 0;
            text-align: center;
            margin-bottom: 30px;
        }
        .header h2 {
            margin: 0;
            font-weight: bold;
        }
        .menu {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        .menu a, .menu button {
            background-color: #f8bbd9; /* Hồng nhạt */
            color: #000;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .menu a:hover, .menu button:hover {
            background-color: #e91e63;
            color: white;
        }
        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 50px;
        }
        .table th {
            background-color: #e91e63;
            color: white;
            text-align: center;
        }
        .table td {
            text-align: center;
            vertical-align: middle;
        }
        .btn-custom {
            background-color: #e91e63;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn-custom:hover {
            background-color: #c2185b;
        }
        .modal-content {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
        }
        .img-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .img-gallery__item img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2><i class="fas fa-volleyball-ball"></i> Quản lý sân cầu lông</h2>
    </div>

    <div class="menu">
        <a href="dashboard_admin.php?pg=addPitch" class="btn"><i class="fas fa-plus"></i> Thêm sân</a>
        <a href="dashboard_admin.php?pg=selectPitch" class="btn"><i class="fas fa-edit"></i> Cập nhật sân</a>
        <form method="post" action="" style="display: inline;">
            <button name="ThemHinhAnh" class="btn"><i class="fas fa-image"></i> Thêm hình ảnh</button>
        </form>
    </div>

    <div class="container">
        <table id="pitchTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th><i class="fas fa-tag"></i> Tên sân</th>
                    <th><i class="fas fa-clock"></i> Mở cửa</th>
                    <th><i class="fas fa-clock"></i> Đóng cửa</th>
                    <th><i class="fas fa-info-circle"></i> Mô tả</th>
                    <th><i class="fas fa-dollar-sign"></i> Giá/giờ</th>
                    <th><i class="fas fa-dollar-sign"></i> Giá cao điểm</th>
                    <th><i class="fas fa-tools"></i> Bảo trì</th>
                    <th><i class="fas fa-list"></i> Loại sân</th>
                    <th><i class="fas fa-calendar"></i> Tạo</th>
                    <th><i class="fas fa-calendar"></i> Cập nhật</th>
                    <th><i class="fas fa-image"></i> Hình ảnh</th>
                    <th><i class="fas fa-trash"></i> Xóa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                    echo "<td>" . $row["time_start"] . "</td>";
                    echo "<td>" . $row["time_end"] . "</td>";
                    echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
                    echo "<td>" . number_format($row["price_per_hour"]) . " VND</td>";
                    echo "<td>" . number_format($row["price_per_peak_hour"]) . " VND</td>";
                    echo "<td>" . ($row["is_maintenance"] ? '<span class="badge bg-warning">Bảo trì</span>' : '<span class="badge bg-success">Hoạt động</span>') . "</td>";
                    echo "<td>" . $row["pitch_type_id"] . "</td>";
                    echo "<td>" . $row["created_at"] . "</td>";
                    echo "<td>" . $row["updated_at"] . "</td>";
                    echo "<td><form action='' method='post' style='display:inline;'><button type='submit' name='Anh' class='btn btn-custom btn-sm'><i class='fas fa-eye'></i></button><input type='hidden' name='hidenId' value='" . $row['id'] . "'></form></td>";
                    echo "<td><form action='' method='post' style='display:inline;'><button type='submit' name='Xoa' class='btn btn-danger btn-sm' onclick='return confirmDelete();'><i class='fas fa-trash'></i></button><input type='hidden' name='hidenId' value='" . $row['id'] . "'></form></td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
        <?php
        if($_SERVER["REQUEST_METHOD"]==='POST') {
            if (isset($_POST['ThemSanCauLong'])) {
            
            $created_at= date('Y-m-d H:i:s'); 
            $updated_at= null;
            checkAddingPitch($_POST['pitchName'], $_POST['pitchTimeStart'], $_POST['pitchTimeEnd'], $_POST['Description'], $_POST['price_per_hour'], 
            $_POST['price_per_peak_hour'], $_POST['is_maintenance'], $_POST['pitch_type_id'], $created_at, $updated_at);
            header("Location: dashboard_admin.php?pg=pitchManage");
              exit();
        }
        if(isset($_POST["Thoat"])) {
            header("Location: dashboard_admin.php?pg=pitchManage");
            exit();

        }
         if(isset($_POST['SuaSanCauLong'])){
            
            $updated_at = date('Y-m-d H:i:s'); 
            checkUpdatePitch($_POST['pitchId2'] ,$_POST['pitchName2'], $_POST['pitchTimeStart2'], $_POST['pitchTimeEnd2'], $_POST['Description2'], $_POST['price_per_hour2'], 
            $_POST['price_per_peak_hour2'], $_POST['is_maintenance2'], $_POST['pitch_type_id2'], $updated_at);
            header("Location: dashboard_admin.php?pg=pitchManage");
            exit();
        }
        if(isset($_POST['Xoa'])){
            $delid = $_POST['hidenId'];
            checkDelete($delid);
            header("Location: dashboard_admin.php?pg=pitchManage");
            exit();
        }

    if (isset($_POST['add'])) {
        $tenSanBong = $_POST['tenSanCauLong'];
        $hinhAnh = trim($_POST['image']);
        $idResult = getID($tenSanBong);

    if ($idResult !== false && $idResult->num_rows > 0) {
        $idRow = $idResult->fetch_assoc();
        $id = $idRow['id']; 

        if (ThemAnh($hinhAnh, $id)) {
            echo "<script type='text/javascript'>alert('Đã thêm hình ảnh thành công.');location.replace('dashboard_admin.php?pg=pitchManage');</script>";
            exit();
        }
    } else {
        echo "<script type='text/javascript'>alert('Không tìm thấy sân cầu lông.');</script>";
    }
}

       }
    ?>

        <script type="text/javascript">
        function confirmDelete() {
            return confirm('Bạn có chắc chắn muốn xóa sân cầu lông này?');
        }

        // Close modals on outside click
        document.querySelectorAll('.modal, .modal2, .modal3, .modal4').forEach(modal => {
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });
        });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </div>
</body>

</html>