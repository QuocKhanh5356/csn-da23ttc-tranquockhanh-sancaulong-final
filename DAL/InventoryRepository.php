<?php
require_once __DIR__ . '/connect_database.php';

class InventoryRepository {
    private $conn;

    public function __construct() {
        $this->conn = getConnection();
    }

    public function getAllItems() {
        $sql = "SELECT * FROM inventory";
        $result = $this->conn->query($sql);
        $items = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
        }
        return $items;
    }

    public function updateQuantity($id, $quantity) {
        $sql = "UPDATE inventory SET quantity=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $quantity, $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}
?>