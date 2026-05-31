<?php
require_once __DIR__ . '/../BLL/UtilitiesService.php';

$utilitiesService = new UtilitiesService();
$message = '';
$messageClass = '';

// Xử lý thêm sản phẩm kho
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $item_name = trim($_POST['item_name']);
    $category = trim($_POST['category'] ?? '');
    $quantity = intval($_POST['quantity']);
    $price = intval(preg_replace('/\D/', '', $_POST['price']));
    $image_url = str_replace('\\', '/', trim($_POST['image_url'] ?? ''));
    $result = $utilitiesService->addInventoryItem($item_name, $category, $quantity, $price, $image_url);
    if ($result) {
        echo '<script type="text/javascript">alert("Sản phẩm đã được thêm vào kho."); window.location.href="dashboard_admin.php?pg=utilitiesManage";</script>';
    } else {
        $message = 'Có lỗi xảy ra khi thêm sản phẩm.';
        $messageClass = 'alert-danger';
    }
}

// Xử lý cập nhật sản phẩm kho
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_product'])) {
    $id = $_POST['id'];
    $item_name = trim($_POST['item_name']);
    $category = trim($_POST['category'] ?? '');
    if ($category === '') {
        $existingItem = $utilitiesService->getInventoryItemById($id);
        $category = $existingItem['category'] ?? '';
    }
    $quantity = intval($_POST['quantity']);
    $price = intval(preg_replace('/\D/', '', $_POST['price']));
    $image_url = str_replace('\\', '/', trim($_POST['image_url'] ?? ''));
    $result = $utilitiesService->updateInventoryItem($id, $item_name, $category, $quantity, $price, $image_url);
    if ($result) {
        echo '<script type="text/javascript">alert("Sản phẩm đã được cập nhật."); window.location.href="dashboard_admin.php?pg=utilitiesManage";</script>';
    } else {
        $message = 'Có lỗi xảy ra khi cập nhật sản phẩm.';
        $messageClass = 'alert-danger';
    }
}

// Xử lý xóa sản phẩm kho
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_product'])) {
    $id = $_POST['id'];
    $result = $utilitiesService->deleteInventoryItem($id);
    if ($result) {
        echo '<script type="text/javascript">alert("Sản phẩm đã được xóa khỏi kho."); window.location.href="dashboard_admin.php?pg=utilitiesManage";</script>';
    } else {
        $message = 'Có lỗi xảy ra khi xóa sản phẩm.';
        $messageClass = 'alert-danger';
    }
}

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

// Xử lý xóa đơn hàng tiện ích
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_order'])) {
    $id = $_POST['id'];
    $result = $utilitiesService->deleteOrder($id);
    if ($result) {
        echo '<script type="text/javascript">alert("Đơn hàng đã được xóa."); window.location.href="dashboard_admin.php?pg=utilitiesManage";</script>';
    } else {
        echo "Có lỗi xảy ra khi xóa đơn hàng!";
    }
}

$inventory = $utilitiesService->getInventory();
$orders = $utilitiesService->getOrders();

function formatOrderItems($order, $category) {
    $items = [];
    if (!empty($order['stringing_details'])) {
        $decoded = json_decode($order['stringing_details'], true);
        if (is_array($decoded) && isset($decoded['items']) && is_array($decoded['items'])) {
            $items = $decoded['items'];
        }
    }

    if (count($items) > 0) {
        $filtered = array_filter($items, function ($item) use ($category) {
            return strtolower($item['category']) === strtolower($category);
        });
        if (count($filtered) > 0) {
            return implode(', ', array_map(function ($item) {
                return $item['name'] . ' (' . $item['quantity'] . ')';
            }, $filtered));
        }
    }

    if ($category === 'drink' && !empty($order['drink_type'])) {
        return $order['drink_type'] . ' (' . $order['drink_quantity'] . ')';
    }
    if ($category === 'racket' && !empty($order['racket_type'])) {
        return $order['racket_type'] . ' (' . $order['racket_quantity'] . ')';
    }

    return '-';
}

function getPurchasedProducts($order) {
    $products = [];

    if (!empty($order['stringing_details'])) {
        $decoded = json_decode($order['stringing_details'], true);
        if (is_array($decoded) && isset($decoded['items']) && is_array($decoded['items'])) {
            foreach ($decoded['items'] as $item) {
                $products[] = $item['name'] . ' (' . $item['quantity'] . ')';
            }
        }
    }

    if (!empty($order['drink_type']) && intval($order['drink_quantity']) > 0) {
        $products[] = $order['drink_type'] . ' (' . intval($order['drink_quantity']) . ')';
    }
    if (!empty($order['racket_type']) && intval($order['racket_quantity']) > 0) {
        $products[] = $order['racket_type'] . ' (' . intval($order['racket_quantity']) . ')';
    }
    if (!empty($order['stringing_service'])) {
        $products[] = 'Quấn vợt';
    }

    return count($products) > 0 ? implode(', ', $products) : '-';
}

function statusLabel($status) {
    return match ($status) {
        'pending' => 'Đang chờ',
        'confirmed' => 'Đã xác nhận',
        'delivered' => 'Đã giao',
        'cancelled' => 'Đã hủy',
        default => ucfirst($status),
    };
}
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
        <?php if (!empty($message)): ?>
            <div class="alert <?php echo $messageClass; ?>" role="alert">
                <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <div class="card mb-4 p-3">
            <h4>Thêm sản phẩm mới</h4>
            <form method="POST" class="row g-3 align-items-end">
                <input type="hidden" name="add_product" value="1">
                <div class="col-md-4">
                    <label class="form-label">Tên vật phẩm</label>
                    <input type="text" name="item_name" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">URL hình ảnh</label>
                    <input type="text" id="new-image-url" name="image_url" class="form-control" placeholder="https://...">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Số lượng</label>
                    <input type="number" name="quantity" class="form-control" min="0" value="0" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Giá</label>
                    <input type="text" name="price" class="form-control currency-input" inputmode="numeric" value="0" required>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-success w-100">Thêm</button>
                </div>
            </form>
        </div>

        <h3>Kho tiện ích</h3>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên vật phẩm</th>
                    <th>Ảnh</th>
                    <th>Số lượng còn</th>
                    <th>Giá</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inventory as $item): ?>
                <tr>
                    <td><?php echo $item['id']; ?></td>
                    <td>
                        <input type="text" name="item_name" form="update-form-<?php echo $item['id']; ?>" value="<?php echo htmlspecialchars($item['item_name'], ENT_QUOTES); ?>" class="form-control form-control-sm">
                    </td>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <img src="<?php echo htmlspecialchars($item['image_url'] ?? '', ENT_QUOTES); ?>" alt="Preview" style="width:80px;height:50px;object-fit:cover;border-radius:6px;border:1px solid #ddd;" onerror="this.src='https://via.placeholder.com/80x50?text=No+Image'">
                            <input type="text" name="image_url" form="update-form-<?php echo $item['id']; ?>" value="<?php echo htmlspecialchars($item['image_url'] ?? '', ENT_QUOTES); ?>" class="form-control form-control-sm" placeholder="https://...">
                        </div>
                    </td>
                    <td>
                        <input type="number" name="quantity" form="update-form-<?php echo $item['id']; ?>" value="<?php echo $item['quantity']; ?>" min="0" class="form-control form-control-sm">
                    </td>
                    <td>
                        <input type="text" name="price" form="update-form-<?php echo $item['id']; ?>" value="<?php echo number_format($item['price'], 0, ',', '.'); ?>" inputmode="numeric" class="form-control form-control-sm currency-input">
                    </td>
                    <td>
                        <form id="update-form-<?php echo $item['id']; ?>" method="POST" style="display: inline-block;">
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                            <button type="submit" name="update_product" class="btn btn-sm btn-primary">Lưu</button>
                        </form>
                        <form method="POST" style="display: inline-block; margin-left: 5px;">
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                            <button type="submit" name="delete_product" class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xóa sản phẩm này?');">Xóa</button>
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
                    <th>#</th>
                    <th>Tên người dùng</th>
                    <th>Sản phẩm mua</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $index => $order): ?>
                <tr>
                    <td><?php echo $index + 1; ?></td>
                    <td><?php echo htmlspecialchars($order['user_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo htmlspecialchars(getPurchasedProducts($order), ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php echo number_format($order['total'], 0, ',', '.') . ' VND'; ?></td>
                    <td><?php echo statusLabel($order['status']); ?></td>
                    <td><?php echo $order['created_at']; ?></td>
                    <td>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $order['id']; ?>">
                            <select name="status">
                                <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>Đang chờ</option>
                                <option value="confirmed" <?php echo $order['status'] == 'confirmed' ? 'selected' : ''; ?>>Đã xác nhận</option>
                                <option value="delivered" <?php echo $order['status'] == 'delivered' ? 'selected' : ''; ?>>Đã giao</option>
                                <option value="cancelled" <?php echo $order['status'] == 'cancelled' ? 'selected' : ''; ?>>Đã hủy</option>
                            </select>
                            <button type="submit" name="update_status" class="btn btn-sm btn-primary">Cập nhật</button>
                        </form>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $order['id']; ?>">
                            <button type="submit" name="delete_order" class="btn btn-sm btn-danger ms-1" onclick="return confirm('Xác nhận xoá đơn hàng này?');">Xóa</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <script>
        function formatCurrencyValue(value) {
            const digits = String(value).replace(/\D/g, '');
            if (digits.length === 0) {
                return '';
            }
            return digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        function unformatCurrencyValue(value) {
            return String(value).replace(/\D/g, '');
        }

        function attachCurrencyFormatting() {
            document.querySelectorAll('.currency-input').forEach(input => {
                const formatInput = () => {
                    const rawValue = unformatCurrencyValue(input.value);
                    const formattedValue = formatCurrencyValue(rawValue);
                    const cursorFromEnd = input.value.length - input.selectionStart;

                    input.value = formattedValue;
                    const newPosition = Math.max(0, input.value.length - cursorFromEnd);
                    input.setSelectionRange(newPosition, newPosition);
                };

                input.addEventListener('input', formatInput);
                input.addEventListener('blur', () => {
                    input.value = formatCurrencyValue(unformatCurrencyValue(input.value));
                });
            });

            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', () => {
                    form.querySelectorAll('.currency-input').forEach(field => {
                        field.value = unformatCurrencyValue(field.value);
                    });
                });
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            attachCurrencyFormatting();

            // Preview new image URL on add form
            const newUrlInput = document.getElementById('new-image-url');
            if (newUrlInput) {
                const preview = document.createElement('img');
                preview.style.width = '80px';
                preview.style.height = '50px';
                preview.style.objectFit = 'cover';
                preview.style.border = '1px solid #ddd';
                preview.style.borderRadius = '6px';
                preview.style.marginLeft = '8px';
                newUrlInput.parentNode.appendChild(preview);
                newUrlInput.addEventListener('input', () => {
                    preview.src = newUrlInput.value || 'https://via.placeholder.com/80x50?text=No+Image';
                });
            }

            // Live preview for update rows
            document.querySelectorAll('input[name="image_url"]').forEach(input => {
                const formId = input.getAttribute('form');
                const cell = input.closest('td');
                if (!cell) return;
                const img = cell.querySelector('img');
                input.addEventListener('input', () => {
                    if (img) img.src = input.value || 'https://via.placeholder.com/80x50?text=No+Image';
                });
            });
        });
    </script>
</body>

</html>