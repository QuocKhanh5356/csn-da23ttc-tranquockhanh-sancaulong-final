<?php
require_once '../BLL/orderService.php';
require_once '../BLL/pitchManageService.php';
$showForm3= isset($_POST['Anh']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử đơn hàng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="css/orderMember.css?v=<?php echo time(); ?>">
</head>

<body>
    <header class="header_pitchManage">
        <div class="header_content">
            <h2>Lịch sử đặt sân</h2>
        </div>
    </header>
    <?php
        if($_SERVER["REQUEST_METHOD"]=='POST')
         if ($showForm3): ?>

    <div class="modal4">
        <div class="modal-content4">
            <?php
        if (isset($_POST['hidenId'])) {
            $result2 = checkPic($_POST['hidenId']);
            if ($result2) {
            echo '<div class="img-gallery">';
            foreach ($result2 as $key => $mt) {                    
                echo '<div class="img-gallery__item">';
                echo "<img src=\"$mt\" alt=\"Mô Tả 1\">";
                echo '</div>';
            } 
            echo '</div>';  
            } else {
                echo "Chưa có ảnh sân này trong dữ liệu";
            }
        }
?>

        </div>
    </div>

    <?php endif;
?>
    <table id="table_order" class="table table-striped table-hover" style="width:100%; margin-bottom:20px;">
        <thead>
            <tr>
                <th>Tên sân cầu lông</th>
                <th>Thời gian bắt đầu</th>
                <th>Thời gian kết thúc</th>
                <th>Tiền cọc</th>
                <th>Tổng số tiền</th>
                <th>Trạng thái</th>
                <th style='text-align: center;'>Hình ảnh</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $id = $_SESSION['user_id'];
            $orders =getOrdersByUserIdd($id);

            foreach ($orders as $order) {
                $pitch = getNameByID($order['badminton_pitch_id']);
                echo "<tr>";
                echo "<td>" . ($pitch ? $pitch : 'Unknown Pitch') . "</td>";
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
                echo "<td style='text-align: center;'><form action='dashboard.php?pg=summary' method='post'><button type='submit' name ='Anh' ><i class='fa-solid fa-eye'></i></button>
                    <input type='hidden' name='hidenId' value='". $order['badminton_pitch_id']."'></form></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    </div>

    <script>
    var modal = document.querySelector('.modal4');
    var modalContent = document.querySelector('.modal-content4');

    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
    </script>

</body>

</html>