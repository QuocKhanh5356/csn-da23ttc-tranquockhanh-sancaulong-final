<?php
require_once '../BLL/orderService.php'; 
require_once '../BLL/pitchManageService.php';

if(isset($_GET['id'])){
    $odderId = $_GET['id'];
    if(removeOrderService($odderId)){
       header('Location: dashboard_admin.php?pg=summary');
       exit();
    }else {
        echo "Cập nhật thất bại, vui lòng kiểm tra lại các thao tác.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="css/orderManage.css?v=<?php echo time(); ?>">
</head>

<body>
    <header class="header_pitchManage">
        <div class="header_content">
            <h2>Quản lý đơn hàng</h2>
        </div>
    </header>
    <table id="table_order" class="table table-striped" style="width:100%; margin-bottom:20px;">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên khách hàng</th>
                <th>Tên sân cầu lông</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Thời gian bắt đầu</th>
                <th>Thời gian kết thúc</th>
                <th>Tiền cọc</th>
                <th>Tổng số tiền</th>
                <th>Trạng thái</th>
                <th colspan="2">Thao Tác</th>

            </tr>
        </thead>
        <tbody>
            <?php
                                $orders = getAllOrders(); 

                                foreach ($orders as $order) {
                                   $pitch = getNameByID($order['badminton_pitch_id']);
                                    echo "<tr>";
                                    echo "<td>{$order['id']}</td>";
                                    echo "<td>{$order['name']}</td>";
                                    echo "<td>" . ($pitch ? $pitch : 'Unknown Pitch') . "</td>";
                                    echo "<td>{$order['phone']}</td>";
                                    echo "<td>{$order['email']}</td>";
                                    echo "<td>{$order['start_at']}</td>";
                                    echo "<td>{$order['end_at']}</td>";
                                    echo "<td>{$order['deposit']}</td>";
                                    echo "<td>{$order['total']}</td>";
                                    echo "<td>";
                                   
                                    if ($order['status'] == 1) {
                                        echo "<span class='badge bg-success'>Đặt sân</span>";
                                    } elseif ($order['status'] == 2) {
                                        echo "<span class='badge bg-warning'>Chuẩn bị kết thúc</span>";
                                    } elseif ($order['status'] == 3) {
                                        echo "<span class='badge bg-secondary'>Kết thúc</span>";
                                    } else {
                                        echo "<span class='badge bg-info'>Đã đặt</span>";
                                    }

                                    echo "</td>";
                                    echo "<td><a href='edit_order.php?id={$order['id']}'><i class='fa-solid fa-gear'></i></a></td>";
                                    echo "<td><a href='orderManage.php?id={$order['id']}' onclick='return confirmDelete();'><i class='fa-solid fa-trash-can'></i></a></td>";
                                    echo "</tr>";
                                }
                                ?>
        </tbody>
    </table>
    </div>
    </section>

    <script type="text/javascript">
    function confirmDelete() {
        return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?');
    }
    </script>

</body>

</html>