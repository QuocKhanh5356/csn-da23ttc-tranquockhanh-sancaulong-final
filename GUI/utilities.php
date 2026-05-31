<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../BLL/UtilitiesService.php';
$utilitiesService = new UtilitiesService();
$user_id = $_SESSION['user_id'] ?? 1;
$inventory = $utilitiesService->getInventory();
$message = '';
$messageClass = '';

// Handle checkout from cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['form_type'] === 'checkout') {
    $items = json_decode($_POST['cart_items'] ?? '[]', true);
    $total = floatval($_POST['cart_total'] ?? 0);

    if (is_array($items) && count($items) > 0 && $total > 0) {
        $result = $utilitiesService->placeCartOrder($user_id, $items, $total);
        if ($result) {
            $message = '✓ Thanh toán giỏ hàng thành công!';
            $messageClass = 'alert-success';
        } else {
            $message = '✗ ' . $utilitiesService->getLastError();
            $messageClass = 'alert-danger';
        }
    } else {
        $message = '✗ Giỏ hàng trống hoặc dữ liệu đơn hàng không hợp lệ.';
        $messageClass = 'alert-danger';
    }
}

// Handle buy now for individual product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['form_type'] === 'buy_now') {
    $item = json_decode($_POST['buy_item'] ?? 'null', true);
    $total = floatval($_POST['buy_total'] ?? 0);

    if (is_array($item) && $total > 0) {
        $result = $utilitiesService->placeCartOrder($user_id, [$item], $total);
        if ($result) {
            $message = '✓ Mua ngay thành công!';
            $messageClass = 'alert-success';
        } else {
            $message = '✗ ' . $utilitiesService->getLastError();
            $messageClass = 'alert-danger';
        }
    } else {
        $message = '✗ Dữ liệu mua ngay không hợp lệ.';
        $messageClass = 'alert-danger';
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cửa hàng Tiện ích - Vợt & Nước Uống</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding: 2rem 0;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Header */
        .page-header {
            background: #007bff;
            color: white;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 3rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .page-header i {
            font-size: 2.8rem;
        }

        /* Main Layout */
        .main-layout {
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 2rem;
            align-items: start;
        }

        /* Products Section */
        .products-section {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 1rem;
            border-bottom: 3px solid #007bff;
        }

        .section-title i {
            color: #007bff;
            font-size: 1.8rem;
        }

        .shop-row {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        /* Product Card */
        .product-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            border: 1px solid #ecf0f1;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
            border-color: #667eea;
        }

        .product-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.05);
        }

        .product-header {
            padding: 1.2rem;
            color: white;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
        }

        .product-header div {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .product-header h3 {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 0;
            flex: 1;
        }

        .product-header i {
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .product-header span {
            font-size: 1.3rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .product-header.racket {
            background: #dc3545;
        }

        .product-header.drink {
            background: #28a745;
        }

        .product-body {
            padding: 1.2rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #007bff;
            margin-bottom: 0.8rem;
        }

        .product-qty-group {
            margin-bottom: 1rem;
        }

        .product-qty-group label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            display: block;
        }

        .product-qty-group input {
            width: 100%;
            padding: 0.6rem;
            border: 2px solid #dfe6ee;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            text-align: center;
        }

        .product-qty-group input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
        }

        .product-actions {
            display: flex;
            gap: 0.8rem;
            margin-top: auto;
        }

        .product-actions button {
            flex: 1;
            padding: 0.8rem;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            color: white;
        }

        .product-actions .btn-cart {
            background: #007bff;
        }

        .product-actions .btn-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 123, 255, 0.3);
        }

        .product-actions .btn-buy-now {
            background: #dc3545;
        }

        .product-actions .btn-buy-now:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
        }

        /* Cart Panel */
        .cart-panel {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            height: fit-content;
            position: sticky;
            top: 2rem;
        }

        .cart-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #007bff;
            font-size: 1.3rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .cart-header i {
            color: #007bff;
            font-size: 1.5rem;
        }

        #cart-content {
            max-height: 400px;
            overflow-y: auto;
            margin-bottom: 1.5rem;
        }

        .cart-item {
            padding: 0.8rem;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 0.8rem;
            border-left: 4px solid #007bff;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            font-size: 0.9rem;
        }

        .cart-item-name {
            font-weight: 700;
            color: #2c3e50;
        }

        .empty-cart {
            text-align: center;
            color: #95a5a6;
            padding: 1.5rem;
            font-size: 0.95rem;
        }

        .cart-total {
            background: #007bff;
            color: white;
            padding: 1rem;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .cart-actions {
            display: flex;
            gap: 0.8rem;
        }

        .cart-actions button {
            flex: 1;
            padding: 0.75rem;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-checkout {
            background: #28a745;
            color: white;
        }

        .btn-checkout:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3);
        }

        .btn-clear {
            background: #ecf0f1;
            color: #2c3e50;
        }

        .btn-clear:hover {
            background: #bdc3c7;
        }

        /* Order History */
        .order-history-section {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            margin-top: 2rem;
            grid-column: 1 / -1;
        }

        .order-history-section h2 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 1rem;
            border-bottom: 3px solid #007bff;
        }

        .order-history-section h2 i {
            color: #007bff;
        }

        .order-history-table {
            font-size: 0.9rem;
            width: 100%;
        }

        .order-history-table thead {
            background: #007bff;
            color: white;
        }

        .order-history-table tbody tr:hover {
            background-color: #ecf0f1;
        }

        .badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        /* Alert */
        .alert {
            border-radius: 10px;
            border: none;
            animation: slideIn 0.3s ease;
            font-weight: 500;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .main-layout {
                grid-template-columns: 1fr;
            }

            .cart-panel {
                position: static;
            }

            .shop-row {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 1.8rem;
            }

            .section-title {
                font-size: 1.3rem;
            }

            .shop-row {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            }

            .product-actions {
                flex-direction: column;
            }

            .product-actions button {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .page-header {
                padding: 1.5rem;
            }

            .page-header h1 {
                font-size: 1.5rem;
                flex-direction: column;
            }

            .shop-row {
                grid-template-columns: 1fr;
            }

            .cart-panel {
                margin-top: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!empty($message)): ?>
            <div class="alert <?php echo $messageClass; ?>" style="margin-top: 1.5rem;"><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>
        <!-- Header -->
        <div class="page-header">
            <h1>
                <i class="fas fa-shopping-cart"></i>
                Cửa Hàng Tiện Ích
            </h1>
        </div>

        <!-- Main Layout -->
        <div class="main-layout">
            <!-- Products Section -->
            <div class="products-section">
                <div class="section-title">
                    <i class="fas fa-store"></i>
                    Danh Sách Sản Phẩm
                </div>
                <div class="shop-row" id="shop-row"></div>
            </div>

            <!-- Cart Panel -->
            <div class="cart-panel">
                <div class="cart-header">
                    <i class="fas fa-shopping-bag"></i>
                    Giỏ Hàng
                </div>
                <div id="cart-content"></div>
                <div class="cart-total">
                    <span>Tổng cộng:</span>
                    <span id="cart-total">0đ</span>
                </div>
                <div class="cart-actions">
                    <button class="btn-checkout" onclick="checkoutCart()">
                        <i class="fas fa-credit-card"></i>
                        Thanh Toán
                    </button>
                    <button class="btn-clear" id="clear-cart">
                        <i class="fas fa-trash"></i>
                        Xóa
                    </button>
                </div>
            </div>
        </div>

        <!-- Order History Section -->
        <div class="order-history-section">
            <h2>
                <i class="fas fa-history"></i>
                Lịch Sử Đơn Hàng
            </h2>
            <div style="overflow-x: auto;">
                <table class="order-history-table table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sản Phẩm</th>
                            <th>Tổng Tiền</th>
                            <th>Trạng Thái</th>
                            <th>Ngày</th>
                        </tr>
                    </thead>
                    <tbody id="order-history-body">
                        <tr>
                            <td colspan="5" class="text-center text-muted">📭 Chưa có đơn hàng nào</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Hidden Forms -->
    <form id="checkout-form" method="POST" style="display: none;">
        <input type="hidden" name="form_type" value="checkout">
        <input type="hidden" name="cart_items" id="cart_items">
        <input type="hidden" name="cart_total" id="cart_total">
    </form>

    <form id="buy-now-form" method="POST" style="display: none;">
        <input type="hidden" name="form_type" value="buy_now">
        <input type="hidden" name="buy_item" id="buy_item">
        <input type="hidden" name="buy_total" id="buy_total">
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const cart = [];
        const products = <?php echo json_encode(array_map(function ($item) {
            return [
                'id' => intval($item['id']),
                'category' => $item['category'],
                'name' => $item['item_name'],
                'price' => floatval($item['price']),
                'quantity' => intval($item['quantity']),
                'image' => !empty($item['image_url']) ? str_replace('\\', '/', $item['image_url']) : (
                    strpos(strtolower($item['category']), 'racket') !== false || strpos(strtolower($item['category']), 'vợt') !== false
                        ? 'https://via.placeholder.com/300x200?text=Vợt+Cầu+Lông'
                        : (strpos(strtolower($item['category']), 'drink') !== false || strpos(strtolower($item['category']), 'nước') !== false
                            ? 'https://via.placeholder.com/300x200?text=Nước+Uống'
                            : 'https://via.placeholder.com/300x200?text=Tiện+Ích')
                )
            ];
        }, $inventory), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>;

        function formatMoney(value) {
            return Number(value).toLocaleString('vi-VN') + 'đ';
        }

        function renderProducts() {
            const shop = document.getElementById('shop-row');
            shop.innerHTML = products.map((product) => {
                const categoryLower = product.category.toLowerCase();
                const headerClass = categoryLower.includes('vợt') || categoryLower.includes('racket') ? 'racket' : 'drink';
                const available = Number(product.quantity);
                const isSoldOut = available <= 0;
                const headerPriceHtml = '';

                return `
                    <div class="product-card">
                        <div class="product-image">
                            <img src="${product.image}" alt="${product.name}" onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">
                        </div>
                        <div class="product-header ${headerClass}">
                            <div>
                                <h3>${product.name}</h3>
                                <div style="font-size:0.9rem; opacity:0.9; margin-top:0.5rem;">Kho: ${available}</div>
                            </div>
                            ${headerPriceHtml}
                        </div>
                        <div class="product-body">
                            <div class="product-price">${formatMoney(product.price)}</div>
                            <div class="product-qty-group">
                                <label>Số lượng</label>
                                <input type="number" class="product-qty" min="1" value="1" data-product-id="${product.id}" ${isSoldOut ? 'disabled' : ''}>
                            </div>
                            <div class="product-actions">
                                <button class="btn-cart" onclick="addToCart(${product.id})" ${isSoldOut ? 'disabled' : ''}>
                                    <i class="fas fa-cart-plus"></i> Giỏ hàng
                                </button>
                                <button class="btn-buy-now" onclick="buyNow(${product.id})" ${isSoldOut ? 'disabled' : ''}>
                                    <i class="fas fa-bolt"></i> Mua ngay
                                </button>
                            </div>
                            ${isSoldOut ? '<div style="margin-top:1rem;color:#e74c3c;font-weight:700;">Hết hàng</div>' : ''}
                        </div>
                    </div>
                `;
            }).join('');
        }

        function addToCart(productId) {
            const product = products.find(p => p.id === productId);
            if (!product) return;

            const inputElement = document.querySelector(`input[data-product-id="${productId}"]`);
            const qty = parseInt(inputElement.value, 10) || 1;

            if (qty <= 0) {
                alert('Vui lòng chọn số lượng hợp lệ.');
                return;
            }

            if (qty > Number(product.quantity)) {
                alert(`Chỉ còn ${product.quantity} đơn vị của sản phẩm này.`);
                return;
            }

            const existing = cart.find(item => item.id === productId);
            if (existing) {
                if (existing.quantity + qty > Number(product.quantity)) {
                    alert(`Chỉ còn ${product.quantity} đơn vị của sản phẩm này.`);
                    return;
                }
                existing.quantity += qty;
            } else {
                cart.push({
                    id: productId,
                    category: product.category,
                    name: product.name,
                    price: product.price,
                    quantity: qty
                });
            }

            renderCart();
            inputElement.value = 1;
        }

        function buyNow(productId) {
            const product = products.find(p => p.id === productId);
            if (!product) return;

            const inputElement = document.querySelector(`input[data-product-id="${productId}"]`);
            const qty = parseInt(inputElement.value, 10) || 1;

            if (qty <= 0) {
                alert('Vui lòng chọn số lượng hợp lệ.');
                return;
            }

            if (qty > Number(product.quantity)) {
                alert(`Chỉ còn ${product.quantity} đơn vị của sản phẩm này.`);
                return;
            }

            const item = {
                id: product.id,
                category: product.category,
                name: product.name,
                price: product.price,
                quantity: qty
            };
            const total = product.price * qty;

            document.getElementById('buy_item').value = JSON.stringify(item);
            document.getElementById('buy_total').value = total;
            document.getElementById('buy-now-form').submit();
        }

        function renderCart() {
            const cartContent = document.getElementById('cart-content');
            const totalElement = document.getElementById('cart-total');

            if (cart.length === 0) {
                cartContent.innerHTML = '<p class="empty-cart">Giỏ hàng trống. Thêm sản phẩm để thanh toán.</p>';
                totalElement.textContent = '0đ';
                return;
            }

            let total = 0;
            cartContent.innerHTML = cart.map((item, index) => {
                const itemTotal = item.price * item.quantity;
                total += itemTotal;

                return `
                    <div class="cart-item">
                        <div>
                            <div class="cart-item-name">${item.name}</div>
                            <div style="color: #7f8c8d; font-size: 0.85rem;">
                                ${item.quantity} x ${formatMoney(item.price)}
                            </div>
                        </div>
                        <div style="text-align: right; flex-shrink: 0;">
                            <div style="font-weight: 700; color: #007bff;">${formatMoney(itemTotal)}</div>
                            <button style="
                                margin-top: 0.4rem;
                                padding: 0.3rem 0.6rem;
                                background: #e74c3c;
                                color: white;
                                border: none;
                                border-radius: 5px;
                                cursor: pointer;
                                font-size: 0.8rem;
                                font-weight: 600;
                                transition: all 0.2s ease;
                            " onclick="removeCartItem(${index})" onmouseover="this.style.background='#c0392b'" onmouseout="this.style.background='#e74c3c'">
                                Xóa
                            </button>
                        </div>
                    </div>
                `;
            }).join('');

            totalElement.textContent = formatMoney(total);
        }

        function removeCartItem(index) {
            cart.splice(index, 1);
            renderCart();
        }

        function clearCart() {
            cart.length = 0;
            renderCart();
        }

        function checkoutCart() {
            if (cart.length === 0) {
                alert('Giỏ hàng trống. Vui lòng thêm sản phẩm trước khi thanh toán.');
                return;
            }

            const total = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);

            document.getElementById('cart_items').value = JSON.stringify(cart);
            document.getElementById('cart_total').value = total;
            document.getElementById('checkout-form').submit();
        }

        function loadOrderHistory() {
            fetch('get_utilities_history.php')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('order-history-body');
                    tbody.innerHTML = '';

                    if (!Array.isArray(data) || data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">📭 Chưa có đơn hàng nào</td></tr>';
                        return;
                    }

                    data.forEach(order => {
                        const statusBadges = {
                            'pending': { text: 'Chờ xử lý', class: 'bg-warning text-dark' },
                            'confirmed': { text: 'Đã xác nhận', class: 'bg-info' },
                            'completed': { text: 'Hoàn thành', class: 'bg-success' },
                            'cancelled': { text: 'Đã hủy', class: 'bg-danger' }
                        };
                        const status = order.status || 'pending';
                        const statusInfo = statusBadges[status] || { text: 'Chờ xử lý', class: 'bg-warning' };

                        const row = `
                            <tr>
                                <td>#${order.id}</td>
                                <td>${order.description || '-'}</td>
                                <td><strong>${formatMoney(parseFloat(order.total))}</strong></td>
                                <td><span class="badge ${statusInfo.class}">${statusInfo.text}</span></td>
                                <td>${new Date(order.created_at).toLocaleDateString('vi-VN')}</td>
                            </tr>
                        `;
                        tbody.innerHTML += row;
                    });
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                    document.getElementById('order-history-body').innerHTML = 
                        '<tr><td colspan="5" class="text-center text-danger">⚠️ Không thể tải lịch sử đơn hàng</td></tr>';
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            renderProducts();
            renderCart();
            loadOrderHistory();

            document.getElementById('clear-cart').addEventListener('click', clearCart);
        });
    </script>
</body>
</html>
