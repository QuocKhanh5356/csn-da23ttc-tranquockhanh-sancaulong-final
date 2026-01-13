<?php
require_once __DIR__ . '/../BLL/InventoryService.php';

$inventoryService = new InventoryService();

// Xử lý cập nhật số lượng
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_quantity'])) {
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];
    $result = $inventoryService->updateQuantity($id, $quantity);
    if ($result) {
        echo '<script type="text/javascript">alert("Số lượng đã được cập nhật."); window.location.href="dashboard_admin.php?pg=inventoryManage";</script>';
    } else {
        echo "Có lỗi xảy ra!";
    }
}

$items = $inventoryService->getAllItems();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý kho</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="css/accountManage.css?v=<?php echo time(); ?>">
</head>

<body>
    <header class="header_pitchManage">
        <div class="header_content">
            <h2>Quản lý kho</h2>
        </div>
    </header>
    <div class="container mt-4">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên vật phẩm</th>
                    <th>Số lượng còn</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><?php echo $item['id']; ?></td>
                    <td><?php echo $item['item_name']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="0" class="form-control d-inline" style="width: 80px;">
                            <button type="submit" name="update_quantity" class="btn btn-primary btn-sm"><i class="fa-solid fa-save"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>