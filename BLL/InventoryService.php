<?php
require_once __DIR__ . '/../DAL/connect_database.php';
require_once __DIR__ . '/../DAL/InventoryRepository.php';

class InventoryService
{
    private $conn;
    private $inventoryRepository;

    public function __construct()
    {
        $this->conn = getConnection();
        $this->inventoryRepository = new InventoryRepository($this->conn);
    }

    public function getAllItems() {
        return $this->inventoryRepository->getAllItems();
    }

    public function updateQuantity($id, $quantity) {
        return $this->inventoryRepository->updateQuantity($id, $quantity);
    }
}
?>