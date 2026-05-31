<?php
require_once __DIR__ . '/../DAL/UtilitiesRepository.php';

class UtilitiesService {
    private $repo;
    private $lastError;

    public function __construct() {
        $this->repo = new UtilitiesRepository();
        $this->lastError = '';
    }

    public function getLastError() {
        return $this->lastError;
    }

    public function getInventory() {
        return $this->repo->getInventory();
    }

    public function getInventoryItemById($id) {
        return $this->repo->getInventoryItemById($id);
    }

    public function getInventoryItemByName($name) {
        return $this->repo->getInventoryItemByName($name);
    }

    public function updateQuantity($id, $quantity) {
        return $this->repo->updateQuantity($id, $quantity);
    }

    public function addInventoryItem($item_name, $category, $quantity, $price, $image_url = '') {
        return $this->repo->addInventoryItem($item_name, $category, $quantity, $price, $image_url);
    }

    public function updateInventoryItem($id, $item_name, $category, $quantity, $price, $image_url = '') {
        return $this->repo->updateInventoryItem($id, $item_name, $category, $quantity, $price, $image_url);
    }

    public function deleteInventoryItem($id) {
        return $this->repo->deleteInventoryItem($id);
    }

    public function placeOrder($user_id, $drink_type, $drink_quantity, $racket_type, $racket_quantity, $stringing_service, $stringing_details) {
        $total = 0;
        $inventory = $this->getInventory();
        $prices = [];
        foreach ($inventory as $item) {
            $prices[$item['item_name']] = $item['price'];
        }

        if ($drink_quantity > 0 && isset($prices[$drink_type])) {
            $total += $prices[$drink_type] * $drink_quantity;
        }
        if ($racket_quantity > 0 && isset($prices[$racket_type])) {
            $total += $prices[$racket_type] * $racket_quantity;
        }
        if ($stringing_service && isset($prices['Dịch vụ quấn vợt'])) {
            $total += $prices['Dịch vụ quấn vợt'];
        }

        return $this->repo->placeOrder($user_id, $drink_type, $drink_quantity, $racket_type, $racket_quantity, $stringing_service, $stringing_details, $total);
    }

    public function placeBadmintonOrder($user_id, $cheap_items, $cheap_quantity, $medium_items, $medium_quantity, $premium_items, $premium_quantity, $notes, $total) {
        $order_description = [];
        if ($cheap_quantity > 0) $order_description[] = "$cheap_quantity x $cheap_items";
        if ($medium_quantity > 0) $order_description[] = "$medium_quantity x $medium_items";
        if ($premium_quantity > 0) $order_description[] = "$premium_quantity x $premium_items";
        $description = implode(", ", $order_description) . ($notes ? " | " . $notes : "");

        return $this->repo->placeOrder($user_id, '', 0, '', 0, 0, $description, $total);
    }

    public function placeCartOrder($user_id, $items, $total) {
        $this->lastError = '';

        if (!is_array($items) || count($items) === 0) {
            $this->lastError = 'Giỏ hàng trống.';
            return false;
        }

        $orderItems = [];
        foreach ($items as $item) {
            $id = intval($item['id'] ?? 0);
            $quantity = intval($item['quantity'] ?? 0);
            if ($id <= 0 || $quantity <= 0) {
                $this->lastError = 'Dữ liệu sản phẩm không hợp lệ.';
                return false;
            }

            $inventoryItem = $this->getInventoryItemById($id);
            if (!$inventoryItem) {
                $this->lastError = 'Sản phẩm không tồn tại trong kho.';
                return false;
            }

            if ($inventoryItem['quantity'] < $quantity) {
                $this->lastError = "Sản phẩm '{$inventoryItem['item_name']}' chỉ còn {$inventoryItem['quantity']} đơn vị.";
                return false;
            }

            $orderItems[] = [
                'id' => $id,
                'name' => $inventoryItem['item_name'],
                'category' => $inventoryItem['category'],
                'quantity' => $quantity,
                'price' => $inventoryItem['price']
            ];
        }

        $this->repo->beginTransaction();

        foreach ($orderItems as $orderItem) {
            if (!$this->repo->decreaseInventory($orderItem['id'], $orderItem['quantity'])) {
                $this->repo->rollback();
                $this->lastError = "Không đủ số lượng '{$orderItem['name']}' để hoàn tất đơn hàng.";
                return false;
            }
        }

        $descriptionPieces = array_map(function ($item) {
            return $item['quantity'] . ' x ' . $item['name'];
        }, $orderItems);
        $description = implode(', ', $descriptionPieces);

        $drinkItems = array_filter($orderItems, function ($item) {
            return strtolower($item['category']) === 'drink';
        });
        $racketItems = array_filter($orderItems, function ($item) {
            return strtolower($item['category']) === 'racket';
        });

        $drink_type = count($drinkItems) ? reset($drinkItems)['name'] : '';
        $drink_quantity = array_reduce($drinkItems, fn($sum, $item) => $sum + $item['quantity'], 0);
        $racket_type = count($racketItems) ? reset($racketItems)['name'] : '';
        $racket_quantity = array_reduce($racketItems, fn($sum, $item) => $sum + $item['quantity'], 0);

        $stringing_details = json_encode([
            'items' => $orderItems,
            'description' => $description
        ], JSON_UNESCAPED_UNICODE);

        $success = $this->repo->placeOrder($user_id, $drink_type, $drink_quantity, $racket_type, $racket_quantity, 0, $stringing_details, $total);
        if (!$success) {
            $this->repo->rollback();
            $this->lastError = 'Lỗi khi lưu đơn hàng. Vui lòng thử lại.';
            return false;
        }

        $this->repo->commit();
        return true;
    }

    private function getOrderItems($order) {
        $items = [];
        if (!empty($order['stringing_details'])) {
            $decoded = json_decode($order['stringing_details'], true);
            if (is_array($decoded) && isset($decoded['items']) && is_array($decoded['items'])) {
                return $decoded['items'];
            }
        }

        if (!empty($order['drink_type']) && intval($order['drink_quantity']) > 0) {
            $items[] = [
                'name' => $order['drink_type'],
                'quantity' => intval($order['drink_quantity'])
            ];
        }
        if (!empty($order['racket_type']) && intval($order['racket_quantity']) > 0) {
            $items[] = [
                'name' => $order['racket_type'],
                'quantity' => intval($order['racket_quantity'])
            ];
        }

        return $items;
    }

    private function restoreInventoryForOrder($order) {
        $items = $this->getOrderItems($order);
        foreach ($items as $item) {
            if (!empty($item['id'])) {
                $this->repo->increaseInventory($item['id'], intval($item['quantity']));
                continue;
            }
            $inventoryItem = $this->getInventoryItemByName($item['name']);
            if ($inventoryItem) {
                $this->repo->increaseInventory($inventoryItem['id'], intval($item['quantity']));
            }
        }
    }

    private function reserveInventoryForOrder($order) {
        $items = $this->getOrderItems($order);
        foreach ($items as $item) {
            $inventoryItem = null;
            if (!empty($item['id'])) {
                $inventoryItem = $this->getInventoryItemById($item['id']);
            }
            if (!$inventoryItem) {
                $inventoryItem = $this->getInventoryItemByName($item['name']);
            }
            if (!$inventoryItem || $inventoryItem['quantity'] < intval($item['quantity'])) {
                return false;
            }
        }

        foreach ($items as $item) {
            $itemId = intval($item['id'] ?? 0);
            if ($itemId > 0) {
                $this->repo->decreaseInventory($itemId, intval($item['quantity']));
                continue;
            }
            $inventoryItem = $this->getInventoryItemByName($item['name']);
            if ($inventoryItem) {
                $this->repo->decreaseInventory($inventoryItem['id'], intval($item['quantity']));
            }
        }

        return true;
    }

    public function getOrders() {
        return $this->repo->getOrders();
    }

    public function getOrdersByUserId($user_id) {
        return $this->repo->getOrdersByUserId($user_id);
    }

    public function updateOrderStatus($id, $status) {
        $order = $this->repo->getOrderById($id);
        if (!$order) {
            $this->lastError = 'Đơn hàng không tồn tại.';
            return false;
        }

        $currentStatus = $order['status'];
        if ($currentStatus === $status) {
            return true;
        }

        $this->repo->beginTransaction();

        if ($currentStatus !== 'cancelled' && $status === 'cancelled') {
            $this->restoreInventoryForOrder($order);
        } elseif ($currentStatus === 'cancelled' && $status !== 'cancelled') {
            if (!$this->reserveInventoryForOrder($order)) {
                $this->repo->rollback();
                $this->lastError = 'Không đủ tồn kho để thay đổi trạng thái đơn hàng.';
                return false;
            }
        }

        $success = $this->repo->updateOrderStatus($id, $status);
        if (!$success) {
            $this->repo->rollback();
            $this->lastError = 'Lỗi cập nhật trạng thái đơn hàng.';
            return false;
        }

        $this->repo->commit();
        return true;
    }

    public function deleteOrder($id) {
        $order = $this->repo->getOrderById($id);
        if (!$order) {
            $this->lastError = 'Đơn hàng không tồn tại.';
            return false;
        }

        $this->repo->beginTransaction();
        if ($order['status'] !== 'cancelled') {
            $this->restoreInventoryForOrder($order);
        }

        $success = $this->repo->deleteOrder($id);
        if (!$success) {
            $this->repo->rollback();
            $this->lastError = 'Lỗi xóa đơn hàng.';
            return false;
        }

        $this->repo->commit();
        return true;
    }
}
?>