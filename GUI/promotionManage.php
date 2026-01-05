<?php
require_once __DIR__ . '/../BLL/promotionService.php';

$promotion = new PromotionService();
$promos = $promotion->getAll();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['them'])){
        $makm = trim($_POST['makm']);
        $muckm = trim($_POST['muckm']);
        $soluong = trim($_POST['soluong']);
        foreach($promos as $promo){
            if($makm == $promo->makm){
                echo '<script type="text/javascript">alert("Đã tồn tại mã giảm giá!");location.replace("dashboard_admin.php?pg=promotionManage");</script>';
                exit();
            }
        }
        $result = $promotion->add($makm, $muckm,$soluong);
        if ($result) {
            echo '<script type="text/javascript">alert("Thêm mã giảm giá thành công.");location.replace("dashboard_admin.php?pg=promotionManage");</script>';
            exit();
        } else {
            echo '<script type="text/javascript">alert("Đã có lỗi khi thêm! Vui lòng kiểm tra lại thao tác.");location.replace("dashboard_admin.php?pg=promotionManage");</script>';
            exit();
        }
    }
    if(isset($_POST['sua'])){
        $makm = $_POST['makm'];
        $muckm = $_POST['muckm'];
        $soluong=$_POST['soluong'];

        $updated = $promotion->update($makm, $muckm, $soluong);

        if ($updated) {
            echo '<script type="text/javascript">alert("Cập nhật mã giảm giá thành công.");location.replace("dashboard_admin.php?pg=promotionManage");</script>';
            exit();
        } else {
            echo '<script type="text/javascript">alert("Cập nhật mã giảm giá thất bại! Vui lòng thực hiện lại thao tác");location.replace("dashboard_admin.php?pg=promotionManage");</script>';
            exit();
        }
    }
    if(isset($_POST['xoa'])){
        $makm = $_POST['makm'];
        $delete = $promotion->delete($makm);
         if ($delete) {
            echo '<script type="text/javascript">alert("Xóa mã giảm giá thành công.");location.replace("dashboard_admin.php?pg=promotionManage");</script>';
            exit();
        } else {
            echo '<script type="text/javascript">alert("Xóa mã giảm giá thất bại! Vui lòng thực hiện lại thao tác");location.replace("dashboard_admin.php?pg=promotionManage");</script>';
            exit();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Promotions</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/managePromotions.css?v=<?php echo time() ?>">

    <script>
    function fillForm(makm, muckm, soluong) {
        document.querySelector('input[name="makm"]').value = makm;
        document.querySelector('input[name="muckm"]').value = muckm;
        document.querySelector('input[name="soluong"]').value = soluong;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const rows = document.querySelectorAll('table tbody tr');

        rows.forEach(row => {
            row.addEventListener('click', function() {
                const cells = row.querySelectorAll('td');
                const makm = cells[1].textContent.trim();
                const muckm = cells[2].textContent.trim();
                const soluong = cells[3].textContent.trim();

                fillForm(makm, muckm, soluong);
            });
        });
    });

    function confirmDelete() {
        if (document.activeElement.getAttribute('name') === 'xoa') {
            // Hiển thị hộp thoại xác nhận
            return confirm("Bạn có chắc chắn muốn xóa không?");
        }
        return true; // Cho phép gửi form nếu không phải nút "Xóa"
    }
    </script>

</head>

<body>
    <header class="header_pitchManage">
        <div class="header_content">
            <h2>Bảo trì khuyến mãi</h2>
        </div>
    </header>


    <div class="container my-4">
        <div class="table-responsive mt-4">
            <table class="table  table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Mã Khuyến Mại</th>
                        <th>Mức Khuyến Mại (%)</th>
                        <th>Giới hạn </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($promos as $promo): ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo htmlspecialchars($promo->makm); ?></td>
                        <td><?php echo htmlspecialchars($promo->muckm); ?></td>
                        <td><?php echo htmlspecialchars($promo->soluong); ?></td>
                    </tr>
                    <?php $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <form action="dashboard_admin.php?pg=promotionManage" method="post" onsubmit="return confirmDelete();">
            <div class="row mt-3">
                <div class="col-md-6 d-flex flex-column justify-content-between">
                    <div>
                        <input type="submit" value="Thêm" class="btn  mb-3 w-100" name="them">
                        <input type="submit" value="Sửa" class="btn  mb-3 w-100" name="sua">
                        <input type="submit" value="Xóa" class="btn  mb-3 w-100" name="xoa">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group mb-3">
                        <span class="input-group-text">Mã khuyến mãi</span>
                        <input type="text" class="form-control" placeholder="Mã khuyến mãi" name="makm" required>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Mức khuyến mãi</span>
                        <input type="text" class="form-control" placeholder="Mức khuyến mãi" name="muckm" required>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Giới hạn</span>
                        <input type="text" class="form-control" placeholder="Giới hạn" name="soluong" required>
                    </div>
                </div>

            </div>
        </form>


    </div>


</body>

</html>