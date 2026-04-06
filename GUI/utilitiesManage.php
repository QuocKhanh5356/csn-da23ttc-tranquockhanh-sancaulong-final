<?php
require_once __DIR__ . '/../BLL/UtilitiesService.php';

$utilitiesService = new UtilitiesService();

// Xử lý cập nhật số lượng kho
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_quantity'])) {
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];
    $result = $utilitiesService->updateQuantity($id, $quantity);
    if ($result) {
        echo '<script type="text/javascript">alert("Số lượng đã được cập nhật."); window.location.href="dashboard_admin.php?pg=utilitiesManage";</script>';
    } else {
        echo "Có lỗi xảy ra!";
    }
}

// Xử lý cập nhật trạng thái đơn hàng
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $result = $utilitiesService->updateOrderStatus($id, $status);
    if ($result) {
        echo '<script type="text/javascript">alert("Trạng thái đã được cập nhật."); window.location.href="dashboard_admin.php?pg=utilitiesManage";</script>';
    } else {
        echo "Có lỗi xảy ra!";
    }
}

$inventory = $utilitiesService->getInventory();
$orders = $utilitiesService->getOrders();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý tiện ích</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/accountManage.css?v=<?php echo time(); ?>">
</head>

<body>
    <header class="header_pitchManage">
        <div class="header_content">
            <h2>Quản lý tiện ích</h2>
        </div>
    </header>
    <div class="container mt-4">
        <h3>Kho tiện ích</h3>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên vật phẩm</th>
                    <th>Danh mục</th>
                    <th>Số lượng còn</th>
                    <th>Giá</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inventory as $item): ?>
                <tr>
                    <td><?php echo $item['id']; ?></td>
                    <td><?php echo $item['item_name']; ?></td>
                    <td><?php echo $item['category']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo number_format($item['price'], 0, ',', '.') . ' VND'; ?></td>
                    <td>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="0" style="width: 80px;">
                            <button type="submit" name="update_quantity" class="btn btn-sm btn-primary">Cập nhật</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3 class="mt-5">Đơn hàng tiện ích</h3>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Nước uống</th>
                    <th>Vợt</th>
                    <th>Quấn vợt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo $order['user_id']; ?></td>
                    <td><?php echo $order['drink_type'] ? $order['drink_type'] . ' (' . $order['drink_quantity'] . ')' : '-'; ?></td>
                    <td><?php echo $order['racket_type'] ? $order['racket_type'] . ' (' . $order['racket_quantity'] . ')' : '-'; ?></td>
                    <td><?php echo $order['stringing_service'] ? 'Có' : 'Không'; ?></td>
                    <td><?php echo number_format($order['total'], 0, ',', '.') . ' VND'; ?></td>
                    <td><?php echo $order['status']; ?></td>
                    <td><?php echo $order['created_at']; ?></td>
                    <td>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $order['id']; ?>">
                            <select name="status">
                                <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="confirmed" <?php echo $order['status'] == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                                <option value="delivered" <?php echo $order['status'] == 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                <option value="cancelled" <?php echo $order['status'] == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                            </select>
                            <button type="submit" name="update_status" class="btn btn-sm btn-primary">Cập nhật</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>