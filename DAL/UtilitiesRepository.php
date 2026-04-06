<?php
require_once 'connect_database.php';

class UtilitiesRepository {
    private $conn;

    public function __construct() {
        $this->conn = getConnection();
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

    public function updateQuantity($id, $quantity) {
        $sql = "UPDATE utilities_inventory SET quantity = ? WHERE id = ?";
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

    public function getOrders() {
        $sql = "SELECT * FROM utilities_orders ORDER BY created_at DESC";
        $result = $this->conn->query($sql);
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
}
?>