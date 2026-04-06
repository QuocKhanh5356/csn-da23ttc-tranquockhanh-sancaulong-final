<?php
require_once __DIR__ . '/../DAL/connect_database.php';

$conn = getConnection();

$filter_type = isset($_GET['filter_type']) ? $_GET['filter_type'] : '';
$filter_value = isset($_GET['filter_value']) ? $_GET['filter_value'] : '';

$where_clause = "WHERE status = 'confirmed'";
if ($filter_type == 'day' && $filter_value) {
    $where_clause .= " AND DATE(created_at) = '$filter_value'";
} elseif ($filter_type == 'month' && $filter_value) {
    $where_clause .= " AND DATE_FORMAT(created_at, '%Y-%m') = '$filter_value'";
}

// Tính tổng doanh thu
$sql_total = "SELECT SUM(total) as total_revenue FROM orders $where_clause";
$result_total = $conn->query($sql_total);
$total_revenue = 0;
if ($result_total && $row = $result_total->fetch_assoc()) {
    $total_revenue = $row['total_revenue'] ? $row['total_revenue'] : 0;
}

// Lấy danh sách orders
$sql_orders = "SELECT id, user_id, badminton_pitch_id, start_at, end_at, total, created_at FROM orders $where_clause ORDER BY created_at DESC";
$result_orders = $conn->query($sql_orders);
$orders = [];
if ($result_orders) {
    while ($row = $result_orders->fetch_assoc()) {
        $orders[] = $row;
    }
}

// Monthly revenue
$sql_monthly = "SELECT DATE_FORMAT(created_at, '%Y-%m') as month, SUM(total) as revenue FROM orders WHERE status = 'confirmed' GROUP BY month ORDER BY month";
$result_monthly = $conn->query($sql_monthly);
$monthly_data = [];
if ($result_monthly) {
    while ($row = $result_monthly->fetch_assoc()) {
        $monthly_data[] = $row;
    }
}

// Weekly revenue
$sql_weekly = "SELECT DATE_FORMAT(created_at, '%Y-%U') as week, SUM(total) as revenue FROM orders WHERE status = 'confirmed' GROUP BY week ORDER BY week";
$result_weekly = $conn->query($sql_weekly);
$weekly_data = [];
if ($result_weekly) {
    while ($row = $result_weekly->fetch_assoc()) {
        $weekly_data[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống kê doanh thu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/accountManage.css?v=<?php echo time(); ?>">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <header class="header_pitchManage">
        <div class="header_content">
            <h2>Thống kê doanh thu</h2>
        </div>
    </header>
    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-6">
                <h4>Tổng doanh thu: <?php echo number_format($total_revenue, 0, ',', '.') . ' VND'; ?></h4>
            </div>
            <div class="col-md-6">
                <form method="GET" class="d-flex">
                    <select name="filter_type" class="form-select me-2" style="width: auto;">
                        <option value="">Chọn loại lọc</option>
                        <option value="day" <?php echo $filter_type == 'day' ? 'selected' : ''; ?>>Theo ngày</option>
                        <option value="month" <?php echo $filter_type == 'month' ? 'selected' : ''; ?>>Theo tháng</option>
                    </select>
                    <input type="date" name="filter_value" value="<?php echo $filter_value; ?>" class="form-control me-2" style="width: auto;">
                    <button type="submit" class="btn btn-primary">Lọc</button>
                </form>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-6">
                <h5>Biểu đồ doanh thu theo tuần</h5>
                <canvas id="weeklyChart"></canvas>
            </div>
            <div class="col-md-6">
                <h5>Biểu đồ doanh thu theo tháng</h5>
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>
        <table class="table table-striped table-hover" id="revenueTable">
            <thead>
                <tr>
                    <th>ID Đơn</th>
                    <th>ID Người dùng</th>
                    <th>ID Sân</th>
                    <th>Thời gian bắt đầu</th>
                    <th>Thời gian kết thúc</th>
                    <th>Doanh thu</th>
                    <th>Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo $order['user_id']; ?></td>
                    <td><?php echo $order['badminton_pitch_id']; ?></td>
                    <td><?php echo $order['start_at']; ?></td>
                    <td><?php echo $order['end_at']; ?></td>
                    <td><?php echo number_format($order['total'], 0, ',', '.') . ' VND'; ?></td>
                    <td><?php echo $order['created_at']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            const weeklyLabels = <?php echo json_encode(array_column($weekly_data, 'week')); ?>;
            const weeklyRevenues = <?php echo json_encode(array_column($weekly_data, 'revenue')); ?>;
            const monthlyLabels = <?php echo json_encode(array_column($monthly_data, 'month')); ?>;
            const monthlyRevenues = <?php echo json_encode(array_column($monthly_data, 'revenue')); ?>;

            new Chart(document.getElementById('weeklyChart'), {
                type: 'bar',
                data: {
                    labels: weeklyLabels,
                    datasets: [{
                        label: 'Doanh thu (VND)',
                        data: weeklyRevenues,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            new Chart(document.getElementById('monthlyChart'), {
                type: 'bar',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Doanh thu (VND)',
                        data: monthlyRevenues,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            $('#revenueTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/vi.json"
                }
            });
        });
    </script>
</body>

</html>