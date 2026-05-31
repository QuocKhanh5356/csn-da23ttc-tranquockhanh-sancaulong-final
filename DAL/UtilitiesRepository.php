<?php
require_once 'connect_database.php';

class UtilitiesRepository {
    private $conn;

    public function __construct() {
        $this->conn = getConnection();

        // Ensure inventory table has image_url column (auto-migrate if missing)
        try {
            $colCheck = $this->conn->query("SHOW COLUMNS FROM utilities_inventory LIKE 'image_url'");
            if ($colCheck && $colCheck->num_rows === 0) {
                $this->conn->query("ALTER TABLE utilities_inventory ADD COLUMN image_url VARCHAR(255) DEFAULT ''");
            }
        } catch (\Throwable $e) {
            // ignore migration errors here; higher-level code will handle runtime errors
        }
    }

    public function beginTransaction() {
        return $this->conn->begin_transaction();
    }

    public function commit() {
        return $this->conn->commit();
    }

    public function rollback() {
        return $this->conn->rollback();
    }

    public function getInventory() {
        $sql = "SELECT * FROM utilities_inventory";
        $result = $this->conn->query($sql);
        $items = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
        }
        return $items;
    }

    public function getInventoryItemById($id) {
        $sql = "SELECT * FROM utilities_inventory WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_assoc() : null;
    }

    public function getInventoryItemByName($name) {
        $sql = "SELECT * FROM utilities_inventory WHERE item_name = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_assoc() : null;
    }

    public function updateQuantity($id, $quantity) {
        $sql = "UPDATE utilities_inventory SET quantity = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $quantity, $id);
        return $stmt->execute();
    }

    public function addInventoryItem($item_name, $category, $quantity, $price, $image_url = '') {
        $sql = "INSERT INTO utilities_inventory (item_name, category, quantity, price, image_url) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssids", $item_name, $category, $quantity, $price, $image_url);
        return $stmt->execute();
    }

    public function updateInventoryItem($id, $item_name, $category, $quantity, $price, $image_url = '') {
        $sql = "UPDATE utilities_inventory SET item_name = ?, category = ?, quantity = ?, price = ?, image_url = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssidsi", $item_name, $category, $quantity, $price, $image_url, $id);
        return $stmt->execute();
    }

    public function deleteInventoryItem($id) {
        $sql = "DELETE FROM utilities_inventory WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function decreaseInventory($id, $quantity) {
        $sql = "UPDATE utilities_inventory SET quantity = quantity - ? WHERE id = ? AND quantity >= ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $quantity, $id, $quantity);
        if (!$stmt->execute()) {
            return false;
        }
        return $stmt->affected_rows > 0;
    }

    public function increaseInventory($id, $quantity) {
        $sql = "UPDATE utilities_inventory SET quantity = quantity + ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $quantity, $id);
        return $stmt->execute();
    }

    public function placeOrder($user_id, $drink_type, $drink_quantity, $racket_type, $racket_quantity, $stringing_service, $stringing_details, $total) {
        $sql = "INSERT INTO utilities_orders (user_id, drink_type, drink_quantity, racket_type, racket_quantity, stringing_service, stringing_details, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("isisiisd", $user_id, $drink_type, $drink_quantity, $racket_type, $racket_quantity, $stringing_service, $stringing_details, $total);
        return $stmt->execute();
    }

    public function getOrderById($id) {
        $sql = "SELECT * FROM utilities_orders WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_assoc() : null;
    }

    public function getOrders() {
        $sql = "SELECT uo.*, u.name AS user_name FROM utilities_orders uo LEFT JOIN users u ON uo.user_id = u.id ORDER BY uo.created_at DESC";
        $result = $this->conn->query($sql);
        $orders = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
        }
        return $orders;
    }

    public function getOrdersByUserId($user_id) {
        $sql = "SELECT * FROM utilities_orders WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $orders = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $orders[] = $row;
            }
        }
        return $orders;
    }

    public function updateOrderStatus($id, $status) {
        $sql = "UPDATE utilities_orders SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }

    public function deleteOrder($id) {
        $sql = "DELETE FROM utilities_orders WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>